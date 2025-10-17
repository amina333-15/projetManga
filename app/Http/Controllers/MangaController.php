<?php
namespace App\Http\Controllers;


use App\Models\Manga;
use App\Services\DessinateurService;
use App\Services\GenreService;
use App\Services\ScenaristeService;
use Exception;
use App\Services\MangaService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MangaController extends Controller
{
    public function listMangas()
    {
        try {
            $service = new MangaService();
            $mangas = $service->getListMangas();
            foreach ($mangas as $manga) {
                if(!file_exists('assets\\images\\'.$manga->couverture)){
                $manga->couverture = "erreur.png";
            }
            }
            return view('listMangas', compact('mangas'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function addManga(){
        try {
            $manga = new Manga();

            return $this->showManga($manga);

        }catch (Exception $exception){
            return view('error', compact('exception'));
        }
    }

    public function validManga(Request $request)
    {
        try {
            $service = new MangaService();
            $id = $request->input('id');


        if ($id){
            $manga = $service->getManga($id);
        }else{
        $manga = new Manga();
        }
        $manga->titre = $request->input('titre');
        $manga->id_genre = $request->input('id_genre');
        $manga->id_dessinateur = $request->input('id_dessinateur');
        $manga->id_scenariste = $request->input('id_scenariste');
        $manga->prix = $request->input('prix');

        $couv = $request->file('couv');
        if ($couv) {
            $manga->couverture = $couv->getClientOriginalName();
            $couv->move(public_path().'\assets\images', $manga->couverture);
        }

            try {
                $request->validate([
                    'titre' => 'required|max:250',
                    'genre' => 'required|exists:genres,id_genre',
                    'dessinateur' => 'required|exists:dessinateur,id_dessinateur',
                    'scenariste' => 'required|exists:scenariste,id_scenariste',
                    'prix' => 'required|numeric|between:0,1000',
                ]);
                if (!$manga->couverture){
                    throw ValidationException::withMessages(['couverture' => 'vous devez fournir une image de couverture']);
                }
        }catch (validationException $exception)
            {
                return $this->showManga($manga)->withErrors($exception->validator);
            }

        $service->saveManga($manga);
        return redirect()->route('listMangas');

        }catch (Exception $exception){

        return view('error', compact('exception'));
}

}

public function editManga($id){
    try {
        $service = new MangaService();
        $manga=$service->getManga($id);
        return $this->showManga($manga);
    } catch (Exception $exception) {
        return view('error', compact('exception'));
    }
}

    public function removeManga(int $id)
    {
        try {
            $service = new MangaService();
            $service->deleteManga($id);
            return redirect()->route('listMangas')->with('success', 'Manga supprimé avec succès.');
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    private function showManga(Manga $manga)
    {
        $serviceG= new GenreService();
        $genres = $serviceG->getListGenre();
        $serviceD = new DessinateurService();
        $dessinateurs = $serviceD->getListDessinateur();
        $serviceS = new ScenaristeService();
        $scenaristes = $serviceS->getListScenariste();
        return view('formMangas', compact('manga', 'genres', 'dessinateurs', 'scenaristes'));
    }

}
