<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/Favicon2.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Gestión Ganadera') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('images/welcome.png') }}');
            background-size: cover;
            background-position: center top;
            background-attachment: fixed;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .wrapper {
            height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .navbar-custom {
            background: linear-gradient(90deg, #16a34a, #15803d);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }
        .navbar-custom .nav-link, .navbar-custom .navbar-brand {
            color: #fff !important;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .navbar-custom .nav-link:hover {
            color: #d4edda !important;
        }
        .main-sidebar {
            position: fixed;
            top: 70px; /* Separado del navbar */
            left: 0;
            height: calc(100vh - 120px); /* Altura ajustada para navbar y footer */
            width: 250px;
            z-index: 1020;
            overflow-y: auto;
            transition: transform 0.3s ease-in-out;
        }
        .sidebar-custom {
            background: linear-gradient(to bottom, #16a34a, #14532d);
            border-right: 2px solid #15803d;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
            height: 100%;
        }
        .sidebar-custom .nav-link {
            color: #fff !important;
            border-radius: 8px;
            margin: 5px 10px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        .sidebar-custom .nav-link:hover {
            background-color: #15803d;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        .sidebar-custom .nav-icon {
            margin-right: 10px;
            font-size: 1.2em;
        }
        .sidebar-custom .brand-text {
            color: #fff;
            font-size: 1.5em;
            font-weight: bold;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
            letter-spacing: 1px;
        }
        .content-wrapper {
            position: absolute;
            bottom: 70px; /* Espacio fijo para el footer */
            left: 270px; /* Espacio inicial para la sidebar */
            right: 10%; /* Margen derecho del 10% */
            height: auto;
            max-height: calc(100vh - 160px); /* Máximo ajustado para navbar y footer */
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 20px; /* Margen fijo en píxeles, no porcentaje */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            transition: all 0.3s ease-in-out;
        }
        /* Cuando la sidebar está oculta */
        body.sidebar-collapse .content-wrapper {
            left: 10%; /* Margen izquierdo del 10% */
            right: 10%; /* Margen derecho del 10% */
        }
        .footer-custom {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: linear-gradient(90deg, #14532d, #16a34a);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.3);
            z-index: 1030;
            font-size: 0.9em;
        }
        .dropdown-menu {
            background-color: #16a34a;
            border: none;
        }
        .dropdown-item {
            color: #fff !important;
        }
        .dropdown-item:hover {
            background-color: #15803d;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-custom">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item">
                    <a class="navbar-brand" href="{{ url('/') }}">Gestión Ganadera</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Cerrar Sesión') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-custom elevation-4">
            <div class="sidebar">
                <!-- Logo y título -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-circle elevation-2" style="width: 40px; margin-right: 10px;">
                    <div class="info">
                        <a href="{{ url('/') }}" class="d-block brand-text">Gestión Ganadera</a>
                    </div>
                </div>

                <!-- Menú -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Para Lechería -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-milk"></i>
                                <p>Para Lechería</p>
                            </a>
                        </li>

                        <!-- Para Animales -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cow"></i>
                                <p>Para Animales</p>
                            </a>
                        </li>

                        <!-- Para Bodega -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>Para Bodega</p>
                            </a>
                        </li>

                        <!-- Para Salud Animal -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-heartbeat"></i>
                                <p>Para Salud Animal</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Contenido principal -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="footer-custom">
            <p>© {{ date('Y') }} Gestión Ganadera. Todos los derechos reservados.</p>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('AdminLTE-3.2.0/dist/js/demo.js') }}"></script>
</body>
</html>