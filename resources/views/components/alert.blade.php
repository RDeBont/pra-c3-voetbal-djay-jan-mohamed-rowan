@if(session('error') || session('success'))
    @php
        $type = session('error') ? 'error' : 'success';
        $message = session('error') ?? session('success');
    @endphp

    <div id="alert-bubble" class="alert-bubble {{ $type }}">
        {{ $message }}
    </div>


@endif

