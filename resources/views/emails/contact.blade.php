<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <style>
    body { font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px; }
    .mailbox { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
    h2 { color: #004aad; }
    p { color: #333; }
  </style>
</head>
<body>
  <div class="mailbox">
    <h2>Nieuw contactbericht</h2>
    <p><strong>Naam:</strong> {{ $gegevens['naam'] }}</p>
    <p><strong>E-mailadres:</strong> {{ $gegevens['email'] }}</p>
    <p><strong>Bericht:</strong></p>
    <p>{{ $gegevens['bericht'] }}</p>
  </div>
</body>
</html>
