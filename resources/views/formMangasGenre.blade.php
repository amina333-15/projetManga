@extends("layouts.master")

@section('content')
    <form method="POST" action="{{ route('listMangasGenre') }}" enctype="multipart/form-data">
        {{csrf_field() }}

        <input type="hidden" name="id" value="{{ $genre->id_genre }}">

        <h1>Filtrer les mangas par genre</h1>

        <div class="col-md-12 card card-body bg-light">
            <!----- Genre ----->
            <div class="form-group">
                <label class="col-md-3">Genre :</label>
                <div class="col-md-6">
                    <select class="form-select @error('genre') border-danger @enderror" name="lib_genre">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id_genre }}" @if ($manga->id_genre == $genre->id_genre) @endif >
                                {{ $genre->lib_genre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!------------------- Début partie validation-------------->
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        Valider
                    </button>
                    <button type="submit" class="btn btn-secondary"
                            onclick="if (confirm('Annuler la saisie ?')) window.location='{{url('/')}}'">
                        Annuler
                    </button>
                </div>
            </div>

        </div>
    </form>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
@endsection
