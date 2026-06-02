<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">{{ $this->title }}</flux:heading>
            <flux:text class="text-zinc-500">
                @if ($this->isEditing)
                    Atualize os dados do entregador.
                @else
                    Cadastre um novo entregador e a capacidade de carga.
                @endif
            </flux:text>
        </div>
        <flux:button
            as="a"
            :href="route('entregadores.index')"
            variant="ghost"
            icon="arrow-left"
            wire:navigate
        >
            Voltar
        </flux:button>
    </div>

    <flux:card>
        <form wire:submit="save" class="space-y-4">
            <flux:input wire:model="nome" label="Nome" required autofocus />

            <flux:input
                wire:model="enderecoBase"
                label="Endereço base (saída e retorno)"
                description="Será geocodificado pelo OpenStreetMap"
                required
            />

            <div class="grid grid-cols-2 gap-3">
                <flux:input
                    wire:model="pesoMaxKg"
                    label="Peso máx. (kg)"
                    type="number"
                    step="0.1"
                    min="0.1"
                    required
                />
                <flux:input
                    wire:model="volumeMaxLitros"
                    label="Volume máx. (L)"
                    type="number"
                    step="0.1"
                    min="0.1"
                    required
                />
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:button
                    as="a"
                    :href="route('entregadores.index')"
                    variant="ghost"
                    type="button"
                    wire:navigate
                >
                    Cancelar
                </flux:button>
                <flux:button variant="primary" type="submit">
                    <span wire:loading.remove wire:target="save">Salvar</span>
                    <span wire:loading wire:target="save">Salvando…</span>
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
