<!DOCTYPE html>
<html>
<head>
    <title>Reservas</title>
</head>
<body>
    <h1>Lista de Reservas</h1>
    <a href="{{ route('reserva.create') }}">Criar Nova Reserva</a>
    <ul>
        @foreach ($reservas as $reserva)
            <li>
                Mesa ID: {{ $reserva->mesa_id }} - Horário: {{ $reserva->horario_inicio }} até {{ $reserva->horario_fim }} - Status: {{ $reserva->status }}
            </li>
        @endforeach
    </ul>
</body>
</html>
