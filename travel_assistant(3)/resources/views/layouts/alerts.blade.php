@if (session()->has('success'))
    <div class="block-success">
        <ul>
            @foreach ((array) session('success') as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if ($errors->any())
    <div class="block-error">
        <ul>
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
