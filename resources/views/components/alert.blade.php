{{-- Validation errors --}}
@if ($errors->any())
    <div id="alert-bubble" class="alert-bubble error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Success message --}}
@if(session('success'))
    <div id="alert-bubble" class="alert-bubble success">
        {{ session('success') }}
    </div>
@endif