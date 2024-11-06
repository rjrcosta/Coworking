<x-index-layout>
  <x-slot name="header" class="">
    <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
      {{ __('Listagem de reservas') }}
    </h2>
    <a href="{{route('reservas.create')}}">
      <x-buttons.create-button class="">{{ __('Criar Novo') }}</x-buttons.create-button>
    </a>
  </x-slot>

  {{-- resources/views/reservas/success.blade.php --}}
  @extends('layouts.app')

  @section('content')
  <div class="container">
    <h1>Check-in realizado com sucesso!</h1>
    <p>Sua reserva foi confirmada. Aproveite seu tempo!</p>
    <a href="{{ route('reservas.index') }}" class="btn btn-primary">Voltar para Reservas</a>
  </div>
  @endsection


</x-index-layout>