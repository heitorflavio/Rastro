<?php

namespace App\Livewire\Entregadores;

use App\Models\Entregador;
use App\Services\Exceptions\AddressNotFoundException;
use App\Services\Geocoder;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.app')]
class Form extends Component
{
    public ?Entregador $entregador = null;

    #[Validate('required|string|min:2|max:120')]
    public string $nome = '';

    #[Validate('required|string|min:5|max:255')]
    public string $enderecoBase = '';

    #[Validate('required|numeric|min:0.1')]
    public float $pesoMaxKg = 0;

    #[Validate('required|numeric|min:0.1')]
    public float $volumeMaxLitros = 0;

    public function mount(?Entregador $entregador = null): void
    {
        if ($entregador && $entregador->exists) {
            $this->entregador = $entregador;
            $this->nome = $entregador->nome;
            $this->enderecoBase = $entregador->endereco_base;
            $this->pesoMaxKg = (float) $entregador->peso_max_kg;
            $this->volumeMaxLitros = (float) $entregador->volume_max_litros;
        }
    }

    #[Computed]
    public function isEditing(): bool
    {
        return $this->entregador !== null;
    }

    #[Computed]
    public function title(): string
    {
        return $this->isEditing() ? 'Editar entregador' : 'Novo entregador';
    }

    public function save(Geocoder $geocoder)
    {
        $this->validate();

        $entregador = $this->entregador ?? new Entregador;

        $data = [
            'nome' => $this->nome,
            'peso_max_kg' => $this->pesoMaxKg,
            'volume_max_litros' => $this->volumeMaxLitros,
            'endereco_base' => $this->enderecoBase,
        ];

        if (! $entregador->exists || $entregador->endereco_base !== $this->enderecoBase) {
            try {
                $geo = $geocoder->geocode($this->enderecoBase);
            } catch (AddressNotFoundException $e) {
                $this->addError('enderecoBase', $e->getMessage());

                return null;
            }
            $data['lat_base'] = $geo['lat'];
            $data['lon_base'] = $geo['lon'];
        }

        $entregador->fill($data)->save();

        return $this->redirectRoute('entregadores.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.entregadores.form')
            ->title($this->title());
    }
}
