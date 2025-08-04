<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Aplikasi Kasir')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 70px; /* tinggi navbar fixed */
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        main {
            flex: 1; /* isi area flexible agar footer terdorong ke bawah */
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .nav-link.active {
            font-weight: 600;
            color: #ffc107 !important;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 1rem 0;
            text-align: center;
            font-size: 0.9rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('beranda') }}">Kasir</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('beranda') }}"
                           class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">
                           Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('produk.index') }}"
                           class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                           Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transaksi.index') }}"
                           class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                           Transaksi
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <small>&copy; {{ date('Y') }} Aplikasi Kasir. All rights reserved.</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
