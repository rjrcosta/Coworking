<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Editar Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name">Nome:</label>
                            <input type="text" name="name" value="{{ $user->name }}" required>
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input type="email" name="email" value="{{ $user->email }}" required>
                        </div>

                        <!-- Adicione outros campos conforme necessário -->

                        <button type="submit">Atualizar Usuário</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>