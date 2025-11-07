@extends("layouts.master")

@section('content')
    <form method="POST" action="{{ route('validManga') }}" enctype="multipart/form-data">
        {{csrf_field() }}

        <input type="hidden" name="id" value="{{ $manga->id_manga }}">

        <h1>@if( $manga->id_manga) Fiche @else Ajout @endif d'un Manga</h1>

        <div class="col-md-12 card card-body bg-light">


            <!----- Titre ---->
            <div class="form-group">
                <label class="col-md-3">Titre :</label>
                <div class="col-md-6">
                    <input type="text" name="titre" value="{{ $manga->titre }}" class="form-control" required>
                </div>
            </div>
            <!----- Genre ----->
            <div class="form-group">
                <label class="col-md-3">Genre :</label>
                <div class="col-md-6">
                    <select class="form-select @error('genre') border-danger @enderror" name="genre">
                        <option disabled selected>Choisir un genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id_genre }}" @if ($manga->id_genre == $genre->id_genre) @endif >
                                {{ $genre->lib_genre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

<!--------- Dessinateur ---------->

            <div class="form-group">
                <label class="col-md-3">Dessinateur :</label>
                <div class="col-md-6">
                    <select class="form-select @error('dessinateur') border-danger @enderror" name="nom_dessinateur">
                        <option disabled selected>Choisir un dessinateur</option>
                        @foreach($dessinateurs as $dessinateur)
                            <option value="{{ $dessinateur->id_dessinateur }}" @if ($manga->id_dessinateur == $dessinateur->id_dessinateur) selected @endif>{{ $dessinateur->nom_dessinateur }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
<!------------ Scénariste ------------>

            <div class="form-group">
                <label class="col-md-3">Scénariste :</label>
                <select class="form-select @error('scenariste') border-danger @enderror" name="id_scenariste"  required>
                    <option disabled selected>Choisir un scénariste</option>
                    @foreach($scenaristes as $scenariste)
                        <option value="{{ $scenariste->id_scenariste }}" @if($manga->id_scenariste == $scenariste->id_scenariste) selected @endif>
                            {{ $scenariste->nom_scenariste }}
                        </option>
                    @endforeach
                </select>
            </div>

<!------------------ Prix ------------------>
            <div class="form-group">
                <label class="col-md-3 @error('prix') border-danger @enderror">Prix (€) :</label>
                <input type="number" step="0.01" name="prix" value="{{ old('prix', $manga->prix) }}" class="form-control" required>
            </div>

<!----------------- Image de couverture ---------------->
            <div class="form-group">
                <label class="col-md-3">Couverture :</label>
                <div class="col-md-6 @error('couv') border-danger @enderror">
                    <input type="hidden" name="MAX-FILE-SIZE" value="204800">
                    <input type="file" accept="image/*" name="couv" class="form-control">
                </div>

{{--                <input type="file" name="couverture" class="form-control">--}}
{{--                    @if($manga->couverture)--}}
{{--                        <p>Image actuelle : <img src="{{ asset('images/' . $manga->couverture) }}" width="100"></p>--}}
{{--                    @endif--}}
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
