



<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhes Pessoais') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    <h1>Meu Perfil</h1>
                    <p>Nome: {{ $user->name }}</p>
                    <p>Email: {{ $user->email }}</p>
                    <a href="{{ route('users.editProfile') }}">Editar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>