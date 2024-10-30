
<div class="container mt-5">
    <h1 class="mb-4">Detalhes da Mesa</h1>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Informações da Mesa</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>ID da Mesa</th>
                        <td>{{ $mesa->id }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Estado da mesa</th>
                        <td>{{ $mesa->status }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Sala</th>
                        <td>{{ $sala->nome }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Piso</th>
                        <td>{{ $piso->andar }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Edifício</th>
                        <td>{{ $edificio->nome }}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>Cidade</th>
                        <td>{{$cidade->nome}}</td>
                    </tr>
                    <br>
                    <tr>
                        <th>QR Code</th>
                        <td>
                            <img src="{{ asset($mesa->qrcode) }}" alt="qrcode" class="img-fluid" style="max-width: 200px;">
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ route('mesa.index') }}" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</div>
