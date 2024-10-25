<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Mesa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        h1 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-top: -10px;
            margin-bottom: 10px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <h1>Criar Mesa</h1>
    <form action="{{ route('mesa.store') }}" method="POST">
        @csrf
        {{-- <label for="numero">Número da Mesa:</label>
        <input type="number" name="numero" id="numero" required value="{{ old('numero') }}">
        @error('numero')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" value="{{ old('descricao') }}">
        @error('descricao')
            <div class="error">{{ $message }}</div>
        @enderror --}}

        <button type="submit">Criar Mesa</button>
    </form>
</body>
</html>