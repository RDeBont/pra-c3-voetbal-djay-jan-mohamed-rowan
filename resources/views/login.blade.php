<x-base-layout>
    <div class="container">
        <h2>Login</h2>
        <div class="loginForm">
            <form method="POST" action="{{ url('/login') }}">
                @csrf

                <div class="formGroup">
                    <label for="username">- Gebruikersnaam -</label>
                </div>
                <div class="formGroup">
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="formGroup">
                    <label for="password">- Wachtwoord -</label>
                </div>
                <div class="formGroup">
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btnLogin">Login</button>
            </form>

        </div>
    </div>
</x-base-layout>
