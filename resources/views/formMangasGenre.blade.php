@extends('layouts.master')

@section('content')
    <h2>Filtrer les mangas par genre</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('validGenre') }}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="genre">Genre :</label>
            <select name="genre" id="genre" class="form-select @error('genre') border-danger @enderror">
                <option disabled selected>Choisir un genre</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id_genre }}" {{ old('genre') == $genre->id_genre ? 'selected' : '' }}>
                        {{ $genre->lib_genre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Valider</button>
            <a href="{{ url('/') }}" class="btn btn-secondary" onclick="return confirm('Annuler la saisie ?')">Annuler</a>
        </div>
    </form>
@endsection
