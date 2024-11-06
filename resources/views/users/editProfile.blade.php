
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Editar Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    <form action="{{ route('users.updateProfile') }}" method="POST">
                        @csrf
                        <!-- <label for="name">Nome:</label>
                        <input type="text" name="name" value="{{ $user->name }}" required> -->
                        <x-input-label value="Nome"/>
                        <x-text-input class="form-control mt-2 mb-2" id="name" name="name" value="{{ $user->name }}" required/>
                        
                        <!-- <label for="email">Email:</label>
                        <input type="email" name="email" value="{{ $user->email }}" required> -->
                        <x-input-label value="Nome"/>
                        <x-text-input class="form-control mt-2 mb-2" id="email" name="email" value="{{ $user->email }}" required/>
                        
                        <button type="submit">Salvar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>