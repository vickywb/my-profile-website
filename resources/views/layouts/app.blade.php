<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title')</title>

    {{-- CSS Style --}}
    @include('components.style')

</head>
<body>
    
    {{-- Navbar --}}
    @include('partials.frontend.navbar')
    
    <main>
        @yield('content')
    </main>
    
    {{-- Footer --}}
    @include('partials.frontend.footer')
    
    {{-- JS Script --}}

    @include('components.script')
</body>
</html>
