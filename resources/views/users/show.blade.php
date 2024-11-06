<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Detalhes do Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">

                    <x-input-label value="ID" />
                    <x-text-input class="form-control mt-2 mb-2" value="{{ $user->id }}" readonly />

                    <x-input-label value="Nome" />
                    <x-text-input class="form-control mt-2 mb-2" value="{{ $user->name }}" readonly />

                    <x-input-label value="Email" />
                    <x-text-input class="form-control mt-2 mb-2" value="{{ $user->email }}" readonly />

                    <x-input-label value="Role" />
                    <x-text-input class="form-control mt-2 mb-2" value="{{ $user->role }}" readonly />


                    <div class="flex items-center justify-end m-4">
                        <a href="{{ route('users.index') }}" > <button class="btn btn-primary ">Voltar</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>