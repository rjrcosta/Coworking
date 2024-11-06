<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="d-flex  justify-content-around">
                        <!-- Edificios -->
                        <div class="card m-3" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title font-semibold text-xl">Edificios</h5>

                                <p class="card-text fs-1 text-center">{{$qtdedificios}}</p>
                                <x-input-label class="text-center" value="Quantidade" />
                            </div>
                        </div>

                        <!-- Users -->
                        <div class="card m-3" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title font-semibold text-xl">Edificios</h5>

                                <p class="card-text fs-1 text-center">{{$qtdusers}}</p>
                                <x-input-label class="text-center" value="Quantidade" />
                            </div>
                        </div>

                        <!-- Reservas -->
                        <div class="card  m-3" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title font-semibold text-xl">Reservas</h5>

                                <p class="card-text fs-1 text-center">{{$qtdreservas}}</p>
                                <x-input-label class="text-center" value="Quantidade" />
                            </div>
                        </div>

                    </div>


                    <div class="d-flex  justify-content-around">
                        <!-- Mesas -->
                        <div class="card  m-3" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title font-semibold text-xl">Mesas</h5>

                                <p class="card-text fs-1 text-center">{{$qtdmesas}}</p>
                                <x-input-label class="text-center" value="Quantidade" />
                            </div>
                        </div>

                        <!-- Pisos -->
                        <div class="card   m-3" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title font-semibold text-xl">Pisos</h5>

                                <p class="card-text fs-1 text-center">{{$qtdpisos}}</p>
                                <x-input-label class="text-center" value="Quantidade" />
                            </div>
                        </div>

                        <!-- Salas -->
                        <div class="card   m-3" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title font-semibold text-xl">Salas</h5>

                                <p class="card-text fs-1 text-center">{{$qtdsalas}}</p>
                                <x-input-label class="text-center" value="Quantidade" />
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>