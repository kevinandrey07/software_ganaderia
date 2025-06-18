<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Ganadero - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2e9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow-x: hidden;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #2d4739;
            padding-top: 20px;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #e6e9d8;
            padding: 15px 25px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover {
            background-color: #3d5a45;
            color: #ffffff;
            padding-left: 35px;
        }

        .sidebar .dropdown-menu {
            background-color: #3d5a45;
            border: none;
            width: 100%;
        }

        .sidebar .dropdown-item {
            color: #e6e9d8;
            padding: 10px 40px;
        }

        .sidebar .dropdown-item:hover {
            background-color: #4a6b52;
            color: #ffffff;
        }

        .top-navbar {
            margin-left: 250px;
            padding: 15px 2vw;
            background-color: #8da960;
            width: calc(100% - 250px);
            position: fixed;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-message {
            color: #ffffff;
            font-size: 24px;
            /* Tamaño más grande */
            font-weight: bold;
            text-align: center;
            flex-grow: 1;
            /* Para centrarlo */
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 80px 2vw 2vw;
            /* Aumentamos el padding-top para dejar espacio al navbar */
            min-height: 100vh;
            width: calc(100% - 250px);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(141, 169, 96, 0.3);
            min-height: calc(100vh - 120px);
            /* Ajustamos la altura para que no se corte */
            overflow-y: auto;
        }

        .main-container:hover {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content-wrapper {
                margin-left: 200px;
                width: calc(100% - 200px);
                padding: 70px 15px 15px;
            }

            .top-navbar {
                margin-left: 200px;
                width: calc(100% - 200px);
            }

            .main-container {
                padding: 15px;
                min-height: calc(100vh - 100px);
            }

            .welcome-message {
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .content-wrapper {
                margin-left: 0;
                width: 100%;
                padding: 60px 10px 10px;
            }

            .top-navbar {
                margin-left: 0;
                width: 100%;
            }

            .main-container {
                min-height: calc(100vh - 80px);
            }

            .welcome-message {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Ejemplo para "Animales" -->
        <div class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#animalesCollapse" role="button" aria-expanded="false">
                Bovinos
            </a>
            <div class="collapse" id="animalesCollapse">
                <a class="nav-link dropdown-item" href="{{ route('razas.index') }}">Razas</a>
                <a class="nav-link dropdown-item" href="{{ route('estados.index') }}">Estados</a>
                <a class="nav-link dropdown-item" href="{{ route('bovinos.create') }}">Agregar Bovinos</a>
                <a class="nav-link dropdown-item" href="{{ route('bovinos.index') }}">Lista de Bovinos</a>
                <a class="nav-link dropdown-item" href="{{ route('bovinos.nutricion') }}#nutricion">Nutrición Bovina</a>
                <a class="nav-link dropdown-item" href="{{ route('bovinos.seguimiento') }}#seguimiento">Seguimiento
                    Bovino</a>
                <a class="nav-link dropdown-item" href="{{ route('bovinos.historial') }}#historial">Historial Bovino</a>
            </div>
        </div>


        <!-- Ejemplo para "Lechería" -->
        <div class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#lecheriaCollapse" role="button" aria-expanded="false">
                Lechería
            </a>
            <div class="collapse" id="lecheriaCollapse">
                <a class="nav-link dropdown-item" href="{{ route('lecheria.create') }}">Agregar Leche</a>
                <a class="nav-link dropdown-item" href="{{ route('lecheria.index') }}">Visualizar Leche</a>
                <a class="nav-link dropdown-item" href="{{ route('lecheria.reportes') }}">Reportes de leche</a>
            </div>

        </div>

        <!-- Repite lo mismo para los demás items -->
        <div class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#saludAnimalCollapse" role="button"
                aria-expanded="false">
                Salud Animal
            </a>
            <div class="collapse" id="saludAnimalCollapse">
                <a class="nav-link dropdown-item" href="{{ route('salud.novedades') }}">Agregar Novedad</a>
                <a class="nav-link dropdown-item" href="{{ route('salud.novedadesLista') }}">Lista de Novedades</a>
                <a class="nav-link dropdown-item" href="{{ route('salud.tratamientos') }}">Tratamientos</a>
                <a class="nav-link dropdown-item" href="{{ route('salud.tratamientosLista') }}">Lista de
                    Tratamientos</a>
                <a class="nav-link dropdown-item" href="{{ route('salud.vacunacion') }}">Vacunación</a>
            </div>

        </div>

        <!-- Potreros -->
        <div class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#potrerosCollapse" role="button" aria-expanded="false">
                Potreros
            </a>
            <div class="collapse" id="potrerosCollapse">
                <a class="nav-link dropdown-item" href="{{ route('potreros.create') }}">Agregar Potreros</a>
                <a class="nav-link dropdown-item" href="{{ route('potreros.index') }}">Gestión de Potreros</a>
                <a class="nav-link dropdown-item" href="{{ route('potreros.visualizar') }}">Visualización de
                    Potreros</a>


            </div>
        </div>


        <!-- Aprendices -->
        <div class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#aprendicesCollapse" role="button"
                aria-expanded="false">
                Aprendices
            </a>
            <div class="collapse" id="aprendicesCollapse">
                <!-- Fichas -->
                <a class="nav-link dropdown-item" href="{{ route('fichas.index') }}">Fichas</a>

                <!-- Aprendices -->
                <a class="nav-link dropdown-item" href="{{ route('aprendices.index') }}">Gestión de Aprendices</a>

                <!-- Tareas -->
                <a class="nav-link dropdown-item" href="{{ route('tareas.index') }}">Tareas</a>
            </div>
        </div>

    </div>



    <!-- Navbar superior con bienvenida y logout -->
    <nav class="top-navbar">
        <span class="welcome-message">
            Bienvenido {{ ucfirst(Auth::user()->role ?? 'Usuario') }}
        </span>
        <ul class="navbar-nav d-flex align-items-center">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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

    <!-- Contenido principal -->
    <div class="content-wrapper">
        <div class="main-container">
            @yield('content')
        </div>
    </div>
    @yield('scripts')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
