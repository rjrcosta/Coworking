<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Reserva</title>
</head>
<body>
    <h1>Criar Reserva</h1>
    <form action="{{ route('reserva.store') }}" method="POST">
        @csrf

        <label for="mesa_id">Mesa:</label>
        <select name="mesa_id" id="mesa_id" required>
            <option value="">Selecione uma mesa</option>
            @foreach ($mesas as $mesa)
                <option value="{{ $mesa->id }}"></option>
            @endforeach
        </select>
        @error('mesa_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="horario_inicio">Horário Início:</label>
        <input type="time" name="horario_inicio" id="horario_inicio" required>
        @error('horario_inicio')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="horario_fim">Horário Fim:</label>
        <input type="time" name="horario_fim" id="horario_fim" required>
        @error('horario_fim')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Criar Reserva</button>
    </form>
</body>
</html>