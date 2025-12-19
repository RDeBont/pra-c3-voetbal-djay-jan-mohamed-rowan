<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuw contactbericht</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #3e6a3e;
            border-bottom: 2px solid #3e6a3e;
            padding-bottom: 10px;
        }
        p {
            line-height: 1.6;
            margin: 8px 0;
        }
        .label {
            font-weight: bold;
        }
        .message-box {
            background-color: #f4f6f4;
            border-left: 4px solid #3e6a3e;
            padding: 12px;
            margin-top: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nieuw contactbericht</h2>

        <p><span class="label">Naam:</span> {{ $gegevens['naam'] }}</p>
        <p><span class="label">E-mailadres:</span> {{ $gegevens['email'] }}</p>

        <p><span class="label">Bericht:</span></p>
        <div class="message-box">
            {{ $gegevens['bericht'] }}
        </div>
    </div>
</body>
</html>
