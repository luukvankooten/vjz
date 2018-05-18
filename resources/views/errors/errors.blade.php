@if($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
                   <li>{{ ucfirst($error) }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('status'))
    <div class="success">
        <ul>
            <li>{{ session('status') }}</li>
        </ul>
    </div>
@endif