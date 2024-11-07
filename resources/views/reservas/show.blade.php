<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhes das reserva') }} {{$reserva->date}} ({{$reserva->id}})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    <p><strong>Data reservada</strong></p>
                    {{ __("$reserva->date") }}
                    <br><br>
                    <p><strong>Período reservado</strong></p>
                    {{ $reserva->buscaPeriodoreservado() }}
                    <br><br>
                    <p><strong>Mesa</strong></p>
                    {{$reserva->mesa ? $reserva->mesa->id : 'Mesa nao encontrada'}}
                    <br><br>
                    <p><strong>Sala</strong></p>
                    {{$sala->nome}}
                    <br><br>
                    <p><strong>Edifício</strong></p>
                    {{$reserva->edificio ? $reserva->edificio->nome : 'Edifício não encontrado'}}
                    <br><br>
                    <p><strong>Cidade</strong></p>
                    {{$reserva->edificio ? $reserva->edificio->cidade->nome : 'Cidade não encontrada'}}
                    <br><br>
                    <p><strong>Estado da reserva</strong></p>

                    @if ($reserva->status == 'reserved')
                    Reservado - Aguardando check-in
                    @elseif ($reserva->status == 'check-in')
                    Reserva com check-in feito
                    @elseif ($reserva->status == 'canceled')
                    Reserva cancelada
                    @else
                    {{ $reserva->status }}
                    @endif
                    <br><br>
                    <p><strong>Data de criação</strong></p>
                    {{$reserva->created_at}}
                    <br><br>
                    <div class="d-flex mb-3">
                        <div class="me-auto p-2"></div>
                        <a href="{{ route('reservas.index') }}"><button type="button" class="btn btn-primary">Voltar</button></a>
                        <div class="p-2"></div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</x-app-layout>