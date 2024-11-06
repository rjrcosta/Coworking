<x-index-layout>
  <x-slot name="header" class="">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de reservas') }}
    </h2>
    <a href="{{route('reservas.create')}}">
      <x-buttons.create-button class="">{{ __('Criar Novo') }}</x-buttons.create-button>
    </a>
  </x-slot>

  {{-- resources/views/reservas/failed.blade.php --}}
  @extends('layouts.app')

  @section('content')
  <div class="container">
    <h1>Check-in não realizado</h1>
    <p>Houve um problema com o seu check-in. Verifique se você possui uma reserva ativa ou se o tempo de check-in não expirou.</p>
    <a href="{{ route('reservas.index') }}" class="btn btn-primary">Voltar para Reservas</a>
  </div>
  @endsection


</x-index-layout>