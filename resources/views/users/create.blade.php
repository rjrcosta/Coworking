<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Excluir Usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-black-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <x-input-label value="Nome"/>
                            <x-text-input class="form-control mt-2 mb-2" id="name" name="name" value="{{ old('name') }}" required/>
                        </div>

                        <div class="form-group">
                            <!-- <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required> -->
                            <x-input-label value="Email"/>
                            <x-text-input class="form-control mt-2 mb-2" id="email" name="email" value="{{ old('email') }}" required/>
                        </div>

                        <div class="form-group">
                            <!-- <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required> -->
                            <x-input-label value="Senha"/>
                            <x-text-input type="password" class="form-control mt-2 mb-2" id="password" name="password" required/>
                        </div>

                        <div class="form-group">
                            <!-- <label for="password_confirmation">Confirme a Senha</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required> -->
                            <x-input-label value="Confirme a Senha"/>
                            <x-text-input type="password" class="form-control mt-2 mb-2" id="password_confirmation" name="password_confirmation" required/>
                        </div>

                        <div class="form-group">
                            <!-- <label for="role">categoria</label> -->
                            <x-input-label class="mb-2" value="Categoria"/>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach ($role as $role)
                                <option value="{{ $role }}">{{ $role }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="flex items-center justify-between m-4">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Criar User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>