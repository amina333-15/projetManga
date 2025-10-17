@extends('layouts.master')
@section('content')
    <h1>Liste des Mangas</h1>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Couverture</th>
            <th>Titre</th>
            <th>Prix</th>
            <th>Genre</th>
            <th>Dessinateur</th>
            <th>Scénariste</th>
            <th><i class="bi bi-pencil"></i></th>
            <th><i class="bi bi-trash"></i></th>

        </tr>
        </thead>
        @foreach($mangas as $manga)
            <tr>
                <td>
                    @if(file_exists(public_path('assets/images/' . $manga->couverture)))
                        <img src="{{ asset('assets/images/' . $manga->couverture) }}" alt="Couverture" style="height:150px;">
                    @else
                        <img src="{{ asset('assets/images/erreur.png') }}" alt="Image manquante" style="height:150px;">
                    @endif
                </td>
                <td>{{$manga->titre}}</td>
                <td>{{$manga->prix}}</td>
                <td>{{$manga->lib_genre}}</td>
                <td>{{$manga->nom_dessinateur}}</td>
                <td>{{$manga->nom_scenariste}}</td>
                <td>
                    <a href="{{ route('editManga', $manga->id_manga) }}"><i class="bi bi-pencil"></i></a>
                </td>
                <td>
                    <a onclick="return confirm('Supprimer ce manga ?')"
                       href="{{route('removeManga',$manga->id_manga)}}"><i class="bi bi-trash"></i></a>
                </td>
        @endforeach


        </tr>

    </table>
@endsection
