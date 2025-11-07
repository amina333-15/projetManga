<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Services\DessinateurService;
use App\Services\GenreService;
use App\Services\ScenaristeService;
use App\Services\MangaService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Exception;

class MangaController extends Controller
{
    public function listMangas()
    {
        try {
            $service = new MangaService();
            $mangas = $service->getListMangas();

            foreach ($mangas as $manga) {
                if (!file_exists(public_path('assets/images/' . $manga->couverture))) {
                    $manga->couverture = 'erreur.png';
                }
            }

            return view('listMangas', compact('mangas'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function addManga()
    {
        try {
            $manga = new Manga();
            return $this->showManga($manga);
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function validManga(Request $request)
    {
        try {
            $service = new MangaService();
            $id = $request->input('id');
            $manga = $id ? $service->getManga($id) : new Manga();

            $manga->titre = $request->input('titre');
            $manga->id_genre = $request->input('genre');
            $manga->id_dessinateur = $request->input('nom_dessinateur');
            $manga->id_scenariste = $request->input('id_scenariste');
            $manga->prix = $request->input('prix');

            $couv = $request->file('couv');
            if ($couv) {
                $manga->couverture = $couv->getClientOriginalName();
                $couv->move(public_path('assets/images'), $manga->couverture);
            }

            $request->validate([
                'titre' => 'required|max:250',
                'genre' => 'required|exists:genre,id_genre',
                'nom_dessinateur' => 'required|exists:dessinateur,id_dessinateur',
                'id_scenariste' => 'required|exists:scenariste,id_scenariste',
                'prix' => 'required|numeric|between:0,1000',
            ]);

            if (!$manga->couverture) {
                throw ValidationException::withMessages(['couv' => 'Vous devez fournir une image de couverture']);
            }

            $service->saveManga($manga);
            return redirect()->route('listMangas');
        } catch (ValidationException $exception) {
            return $this->showManga($manga)->withErrors($exception->validator);
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editManga($id)
    {
        try {
            $service = new MangaService();
            $manga = $service->getManga($id);
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
        $serviceG = new GenreService();
        $genres = $serviceG->getListGenre();

        $serviceD = new DessinateurService();
        $dessinateurs = $serviceD->getListDessinateur();

        $serviceS = new ScenaristeService();
        $scenaristes = $serviceS->getListScenariste();

        return view('formMangas', compact('manga', 'genres', 'dessinateurs', 'scenaristes'));
    }

    public function selectGenre()
    {
        try {
            $service = new GenreService();
            $genres = $service->getListGenre();
            return view('formMangasGenre', compact('genres'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }


    public function validGenre(Request $request)
    {
        try {
            $request->validate([
                'genre' => 'required|exists:genre,id_genre'
            ]);

            $idGenre = $request->input('genre');
            $service = new MangaService();
            $mangas = $service->getMangasByGenre($idGenre);
            $genre = $service->getGenre($idGenre);

            foreach ($mangas as $manga) {
                if (!file_exists(public_path('assets/images/' . $manga->couverture))) {
                    $manga->couverture = 'erreur.png';
                }
            }

            return view('listMangas', [
                'mangas' => $mangas,
                'titre' => 'Mangas du genre : ' . $genre->lib_genre
            ]);
        } catch (ValidationException $exception) {
            $service = new GenreService();
            $genres = $service->getListGenre();
            return view('formGenre', compact('genres'))->withErrors($exception->validator);
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
