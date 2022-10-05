<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('components.head')
<body>
    <div id="app">
        @include('components.navbar')
        <div class="container py-4">
            @yield('content')
        </div>
    </div>
    @include('components.scripts')
</body>
</html>
