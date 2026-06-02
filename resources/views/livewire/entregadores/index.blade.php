<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Entregadores</flux:heading>
            <flux:text class="text-zinc-500">Cadastre seus entregadores e a capacidade de carga de cada um.</flux:text>
        </div>
        <flux:button
            variant="primary"
            icon="plus"
            as="a"
            :href="route('entregadores.create')"
            wire:navigate
        >
            Novo entregador
        </flux:button>
    </div>

    <flux:card>
        @if ($entregadores->isEmpty())
            <flux:text class="text-zinc-500">Nenhum entregador cadastrado ainda.</flux:text>
        @else
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Nome</flux:table.column>
                    <flux:table.column>Base</flux:table.column>
                    <flux:table.column align="end">Peso máx.</flux:table.column>
                    <flux:table.column align="end">Volume máx.</flux:table.column>
                    <flux:table.column align="end">Ações</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($entregadores as $e)
                        <flux:table.row wire:key="entregador-{{ $e->id }}">
                            <flux:table.cell class="font-medium">{{ $e->nome }}</flux:table.cell>
                            <flux:table.cell class="text-zinc-500">{{ $e->endereco_base }}</flux:table.cell>
                            <flux:table.cell align="end">{{ number_format($e->peso_max_kg, 1, ',', '.') }} kg</flux:table.cell>
                            <flux:table.cell align="end">{{ number_format($e->volume_max_litros, 1, ',', '.') }} L</flux:table.cell>
                            <flux:table.cell align="end">
                                <flux:button.group>
                                    <flux:button
                                        size="sm"
                                        icon="map"
                                        as="a"
                                        :href="route('entregadores.roteirizar', $e)"
                                        title="Roteirizar"
                                    />
                                    <flux:button
                                        size="sm"
                                        icon="pencil"
                                        as="a"
                                        :href="route('entregadores.edit', $e)"
                                        wire:navigate
                                        title="Editar"
                                    />
                                    <flux:button
                                        size="sm"
                                        icon="trash"
                                        wire:click="delete({{ $e->id }})"
                                        wire:confirm="Tem certeza? Esta ação não pode ser desfeita."
                                        title="Excluir"
                                    />
                                </flux:button.group>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        @endif
    </flux:card>
</div>
