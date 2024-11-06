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
          <div class="container">
            <h1>Check-in não realizado</h1>
            <br><br>
            <p>Houve um problema com o seu check-in. Verifique se você possui uma reserva ativa ou se o tempo de check-in não expirou.</p>
            <br><br>
            <a href="{{ route('reservas.index') }}" class="btn btn-primary">Voltar para Reservas</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>