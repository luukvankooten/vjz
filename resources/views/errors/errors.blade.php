@if($errors->any() || session('status'))
    <div class="messages">
        <ul>
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <li class="error">{{ ucfirst($error) }}</li>
                @endforeach
            @endif
            @if(session()->has('status'))
                    <li class="success">{{ session('status') }}</li>
            @endif
        </ul>
    </div>
@endif