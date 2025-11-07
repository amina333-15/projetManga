<!doctype html>
<html lang="fr">

<head>
    <title>Application</title>
    <meta charset="UTF-8">
    <link rel="icon" href="{{url('/assets/images/logo.png')}}" type="image/png">
    <link rel="stylesheet" href="{{url('/assets/css/mangas.css')}}">
    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('/assets/icons/bootstrap-icons.css') }}"/>


</head>

<body class="body">
<div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}"><i class=" bi bi-book"></i> Mangas</a>
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Lister
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('listMangas') }}">Tous</a></li>
                            <li><a class="dropdown-item" href="{{ route('selectGenre') }}">Par genre</a></li>
                            <li><a class="dropdown-item" href="{{ route('recherche') }}">Rechercher</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/ajouterManga') }}">Ajouter</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

</div>
<div class="container">
    @yield('content')
</div>

<script src="{{ url('/assets/js/bootstrap.bundle.min.js') }} "></script>
</body>

</html>
