<?php
namespace App\Http\Controllers;


use App\Models\Manga;
use App\Services\DessinateurService;
use App\Services\GenreService;
use App\Services\ScenaristeService;
use Exception;
use App\Services\MangaService;
use Illuminate\Http\Request;

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

            $service= new GenreService();
            $genres = $service->getListGenre();
            $service = new DessinateurService();
            $dessinateurs = $service->getListDessinateur();
            $service = new ScenaristeService();
            $scenaristes = $service->getListScenariste();

            return view('formMangas', compact('manga', 'genres', 'dessinateurs', 'scenaristes'));
        }catch (Exception $exception){
            return view('error', compact('exception'));
        }
    }

    public function validManga(Request $request){
        try {
        $service = new MangaService();
        $id = $request->input('id');

        if ($id){
            $manga = $service->getManga($id);
        }else{
        $manga = new Manga();
        }
        $manga->titre = $request->input('titre');
        $manga->id_genre = $request->input('lib_genre');
        $manga->id_dessinateur = $request->input('nom_dessinateur');
        $manga->id_scenariste = $request->input('id_scenariste');
        $manga->prix = $request->input('prix');

        $couv = $request->file('couv');
        if ($couv) {
            $manga->couverture = $couv->getClientOriginalName();
            $couv->move(public_path().'assets\\images\\', $manga->couverture);
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

        return view('formMangas', compact('manga'));
    } catch (Exception $exception) {
        return view('error', compact('exception'));
    }
}

}
