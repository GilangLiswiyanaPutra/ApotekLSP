<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Apotek App')</title>

    {{-- Ini cara yang benar memanggil semua aset di Laravel 11 --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    <div>

        {{-- Sidebar harus ada di sini --}}
        @include('layouts.partials.sidebar')

        {{-- Pembungkus utama untuk konten di sebelah kanan sidebar --}}
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">

                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    
    {{-- Include reusable modals --}}
    @include('layouts.partials.delete-modal')
    @include('layouts.partials.transaction-modal')
    @include('layouts.partials.order-modal')
    
    @stack('scripts')
</body>
</html>