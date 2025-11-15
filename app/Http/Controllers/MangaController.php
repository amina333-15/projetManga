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
                $manga->couverture = time() . '_' . $couv->getClientOriginalName();
                $couv->move(public_path('assets/images'), $manga->couverture);
            }

            $request->validate([
                'titre' => 'required|max:250',
                'genre' => 'required|exists:genres,id_genre',
                'nom_dessinateur' => 'required|exists:dessinateurs,id_dessinateur',
                'id_scenariste' => 'required|exists:scenaristes,id_scenariste',
                'prix' => 'required|numeric|between:0,1000',
            ]);

            if (!$manga->couverture) {
                throw ValidationException::withMessages(['couv' => 'Vous devez fournir une image de couverture']);
            }

            $service->saveManga($manga
