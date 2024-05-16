@if(session()->has('message'))
    <div class="fixed left-1/2 top-0  -translate-x-1/2 transform bg-laravel text-white px-48 py-3">
        <p>
            {{session('message')}}
        </p>
    </div>
@endif
