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
                            <x-input-label value="Nome"/>
                            <x-text-input class="form-control mt-2 mb-2" id="name" name="name" value="{{ $user->name }}" required/>
                        </div>

                        <div>
                            <x-input-label value="Nome"/>
                            <x-text-input class="form-control mt-2 mb-2" id="email" name="email" value="{{ $user->email }}" required/>
                        </div>

                        <!-- Adicione outros campos conforme necessário -->

                        <div class="flex items-center justify-end m-4">
                            <button type="submit" class="btn btn-primary ">Actualizar User</button>
                        </div>

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>