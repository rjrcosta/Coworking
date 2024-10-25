<?xml version="1.0" encoding="UTF-8"?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html>
<html>

<head>
    <title>Mesas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        a {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background: #f9f9f9;
            margin: 10px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mesa-info {
            display: flex;
            align-items: center;
        }

        .mesa-info img {
            margin-left: 10px;
            width: 100;
            /* Ajuste o tamanho do QR Code conforme necessário */
            height: 100;
            /* Ajuste o tamanho do QR Code conforme necessário */
        }

        .checkin-button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkin-button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h1>Lista de Mesas</h1>
    <a href="{{ route('mesa.create') }}">Criar Nova Mesa</a>
    <ul>
        @foreach ($mesas as $mesa)
            <li>
                <div class="mesa-info">
                    <span><strong>Mesa {{ $mesa->id }}</strong> </span>
                    
                   

                    
    
                    <img src="{{asset( $mesa->qrcode )}}" alt="QR Code para Mesa {{ $mesa->id }}">
                     
               
                </div>
                <form action="{{ route('mesa.checkin', $mesa->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="checkin-button">Check-in</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>

</html>
