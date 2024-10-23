<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black-800 dark:text-black-200 leading-tight">
            {{ __('Listagem de clientes') }}
        </h2>

        {{-- <a href="{{route('user.create')}}"><button  class="btn btn-primary" >Novo cliente</button></a> --}}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-black-900 dark:text-black-100">
                  <div>
                    
                    {{$users->links()}}
                   
             </div>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nome</th>
                            
                            <th scope="col">role</th>

                            <th colspan="3"   scope="col">Opções</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($users as $user)
                          @if($user->role == 'user')
                          <tr>
                            <th>{{ $user->id }}</th> 
                            <td>{{ $user->name }}</td> 
                            
                            <td>{{$user->role}}</td>

                            <td><a href="{{route('users.show',$user->id)}}"><button type="button" class="btn btn-info">Mostrar</button></a></td>
                            <td><a href="{{route('users.edit',$user->id)}}"><button type="button" class="btn btn-warning">editar</button></a> </td>
                           
                            <td>
                              <form action="{{ route('users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este usuário?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger">eliminar</button>
                              </form>
                          </td>
                           
                          </tr>
                          @endif
                        @endforeach

  
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
