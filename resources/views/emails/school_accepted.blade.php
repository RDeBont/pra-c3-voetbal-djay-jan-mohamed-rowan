<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inschrijving Geaccepteerd</title>
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
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo img {
            max-height: 70px;
        }
        h2 {
            color: #3e6a3e;
            border-bottom: 2px solid #3e6a3e;
            padding-bottom: 10px;
        }
        p {
            line-height: 1.6;
        }
        ul {
            padding-left: 20px;
        }
        li {
            margin-bottom: 8px;
        }
        code {
            background-color: #f0f0f0;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #555;
        }
        a {
            color: #3e6a3e;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Logo -->
        <div class="logo">
            <img src="{{ $message->embed(public_path('images/logo.png')) }}" alt="Logo">
        </div>

        <h2>Gefeliciteerd — uw school is geaccepteerd</h2>
        <p>Beste {{ $school->name }},</p>
        <p>Uw inschrijving is geaccepteerd. Hieronder staan de drie accounts die zijn aangemaakt en gekoppeld aan uw school. Gebruik deze inloggegevens om in te loggen en teams/activiteiten te beheren:</p>
        <ul>
            @foreach($accounts as $acc)
                <li>{{ $acc['email'] }} — wachtwoord: <code>{{ $acc['password_plain'] }}</code></li>
            @endforeach
        </ul>
        <p>Wachtwoord vergeten? Neem contact met ons op via de website, stuur ons een mail via <strong>paastoernooienboz@outlook.com</strong> of bel <strong>06-14605997</strong>.</p>
        <div class="footer">
            <p>Met vriendelijke groet,<br>De Organisatie</p>
        </div>
    </div>
</body>
</html>
