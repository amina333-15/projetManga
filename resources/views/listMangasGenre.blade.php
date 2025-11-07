@extends('layouts.master')

@section('content')
    <h2>{{ $titre ?? 'Liste des mangas' }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($mangas) > 0)
        <div class="row">
            @foreach($mangas as $manga)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('assets/images/' . $manga->couverture) }}" class="card-img-top" alt="Couverture">
                        <div class="card-body">
                            <h5 class="card-title">{{ $manga->titre }}</h5>
                            <p><strong>Genre :</strong> {{ $manga->lib_genre }}</p>
                            <p><strong>Dessinateur :</strong> {{ $manga->nom_dessinateur }}</p>
                            <p><strong>Scénariste :</strong> {{ $manga->nom_scenariste }}</p>
                            <p><strong>Prix :</strong> {{ $manga->prix }} €</p>
                            <a href="{{ route('editManga', $manga->id_manga) }}" class="btn btn-warning">Modifier</a>
                            <a href="{{ route('removeManga', $manga->id_manga) }}" class="btn btn-danger" onclick="return confirm('Supprimer ce manga ?')">Supprimer</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Aucun manga trouvé.</p>
    @endif
@endsection
