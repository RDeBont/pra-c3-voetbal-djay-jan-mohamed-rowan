<h2>Gefeliciteerd — uw school is geaccepteerd</h2>
<p>Beste {{ $school->name }},</p>
<p>Uw inschrijving is geaccepteerd. Hieronder staan de drie accounts die zijn aangemaakt en gekoppeld aan uw school. Gebruik deze inloggegevens om in te loggen en teams/activiteiten te beheren.</p>
<ul>
    @foreach($accounts as $acc)
        <li><strong>{{ $acc['email'] }}</strong> — wachtwoord: <code>{{ $acc['password_plain'] }}</code></li>
    @endforeach
</ul>
<p>Met vriendelijke groet,<br>Organisatie</p>
