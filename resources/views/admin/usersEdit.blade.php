<x-base-layout>
    <main class="user-edit-page">
        <h1>Bewerk Gebruiker</h1>

        <!-- Success message -->
        @if(session('success'))
            <div class="admin-message">{{ session('success') }}</div>
        @endif

        <!-- Foutmeldingen -->
        @if($errors->any())
            <div class="admin-message" style="background-color:#f8d7da; color:#721c24; border:1px solid #f5c6cb;">
                <ul style="list-style:none; padding:0; margin:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" placeholder="Laat leeg om niet te wijzigen">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Bevestig Wachtwoord:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Bevestig wachtwoord">
            </div>

            <div class="form-group">
                <label for="is_admin">Rol:</label>
                <select id="is_admin" name="is_admin" required>
                    <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                    <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>School</option>
                </select>
            </div>

            <button type="submit" class="btn-update-user">Update Gebruiker</button>
        </form>
    </main>
</x-base-layout>
