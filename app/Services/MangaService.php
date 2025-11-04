<?php

namespace App\Services;

use App\Models\Genre;
use App\Models\Manga;
use App\Exceptions\UserException;
use Illuminate\Database\QueryException;

class MangaService
{
    public function getListMangas(){
        try {
            $liste = Manga::query()
                ->select('manga.*', 'genre.lib_genre','dessinateur.nom_dessinateur','scenariste.nom_scenariste')
                ->join('genre','genre.id_genre', '=','manga.id_genre')
                ->join('dessinateur','dessinateur.id_dessinateur', '=','manga.id_dessinateur')
                ->join('scenariste','scenariste.id_scenariste', '=','manga.id_scenariste')
                ->get();
            return $liste;
        } catch(QueryException $exception){
            $userMessage="Impossible d'accéder à la base de données.";
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }

    public function saveManga(Manga $manga){
        try {
            $manga->save();
        } catch(QueryException $exception) {
            if (!$manga->titre) {
                $userMessage = "Vous devez renseigner un titre.";
            } else if (!$manga->id_genre) {
                $userMessage = "Vous devez séléctionner un genre.";
            } else if (!$manga->id_dessinateur) {
                $userMessage = "Vous devez séléctionner un dessinateur.";
            } else if (!$manga->id_scenariste) {
                $userMessage = "Vous devez séléctionner un scenariste.";
            } else if (!$manga->couverture) {
                $userMessage = "Vous devez séléctionner une couverture.";
            } else {
                $userMessage = "Impossible de mettre à jour la base de données.";
            }
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }

    public function getManga(mixed $id)
    {
        try {
            $manga = Manga::query()->find($id);
            return $manga;
        } catch(QueryException $exception){
            $userMessage="Impossible d'accéder à la base de données.";
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }
    public function deleteManga($id)
    {
        try{
        $manga = Manga::find($id);

        if ($manga) {
            $manga->delete();
        } else {
            echo "Le manga avec l'ID $id est introuvable.";
        }
        } catch(QueryException $exception){
        $userMessage="Impossible d'accéder à la base de données.";
        throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
    }}


        public function getListMangasGenre()
        {
            try {
                $liste = Genre::query()
                    ->select(
                        'manga.*',
                        'genre.lib_genre',
                        'dessinateur.nom_dessinateur',
                        'scenariste.nom_scenariste'
                    )
                    ->join('genre', 'genre.id_genre', '=', 'manga.id_genre')
                    ->join('dessinateur', 'dessinateur.id_dessinateur', '=', 'manga.id_dessinateur')
                    ->join('scenariste', 'scenariste.id_scenariste', '=', 'manga.id_scenariste')
                    ->get();

                return $liste;
            } catch (\Illuminate\Database\QueryException $exception) {
                $userMessage = "Impossible d'accéder à la base de données.";
                throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
            }
        }


}
