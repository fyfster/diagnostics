@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if (Session::has('messageType'))
    <div class="alert alert-{{ session('messageType') }}">
        {{ Session::get('messageText') }}
    </div>
@endif