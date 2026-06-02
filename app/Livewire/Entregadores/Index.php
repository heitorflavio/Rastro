<?php

namespace App\Livewire\Entregadores;

use App\Models\Entregador;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Entregadores')]
#[Layout('layouts.app')]
class Index extends Component
{
    public function delete(int $id): void
    {
        Entregador::whereKey($id)->delete();
    }

    public function render()
    {
        return view('livewire.entregadores.index', [
            'entregadores' => Entregador::orderBy('nome')->get(),
        ]);
    }
}
