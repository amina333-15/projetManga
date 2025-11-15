<?php

namespace App\Services;

use App\Models\Genre;
use App\Models\Manga;
use App\Exceptions\UserException;
use Illuminate\Database\QueryException;

class MangaService
{
    public function getListMangas()
    {
        try {
            return Manga::query()
                ->select('manga.*', 'genre.lib_genre', 'dessinateur.nom_dessinateur', 'scenariste.nom_scenariste')
                ->join('genre', 'genre.id_genre', '=', 'manga.id_genre')
                ->join('dessinateur', 'dessinateur.id_dessinateur', '=', 'manga.id_dessinateur')
                ->join('scenariste', 'scenariste.id_scenariste', '=', 'manga.id_scenariste')
                ->get();
        } catch (QueryException $exception) {
            throw new UserException("Impossible d'accéder à la base de données.", $exception->getMessage(), $exception->getCode());
        }
    }

    public function saveManga(Manga $manga)
    {
        try {
            $manga->save();
        } catch (QueryException $exception) {
            $userMessage = match (true) {
                !$manga->titre => "Vous devez renseigner un titre.",
                !$manga->id_genre => "Vous devez sélectionner un genre.",
                !$manga->id_dessinateur => "Vous devez sélectionner un dessinateur.",
                !$manga->id_scenariste => "Vous devez sélectionner un scénariste.",
                !$manga->couverture => "Vous devez fournir une couverture.",
                default => "Impossible de mettre à jour la base de données.",
            };
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }

    public function getManga(mixed $id)
    {
        try {
            return Manga::find($id);
        } catch (QueryException $exception) {
            throw new UserException("Impossible d'accéder à la base de données.", $exception->getMessage(), $exception->getCode());
        }
    }

    public function deleteManga($id)
    {
        try {
            $manga = Manga::find($id);
            if ($manga) {
                $manga->delete();
            } else {
                throw new UserException("Le manga avec l'ID $id est introuvable.");
            }
        } catch (QueryException $exception) {
            throw new UserException("Impossible d'accéder à la base de données.", $exception->getMessage(), $exception->getCode());
        }
    }

    public function getMangasByGenre($idGenre)
    {
        try {
            return Manga::query()
                ->select('manga.*', 'genre.lib_genre', 'dessinateur.nom_dessinateur', 'scenariste.nom_scenariste')
                ->join('genre', 'genre.id_genre', '=', 'manga.id_genre')
                ->join('dessinateur', 'dessinateur.id_dessinateur', '=', 'manga.id_dessinateur')
                ->join('scenariste', 'scenariste.id_scenariste', '=', 'manga.id_scenariste')
                ->where('manga.id_genre', $idGenre)
                ->get();
        } catch (QueryException $exception) {
            throw new UserException("Impossible d'accéder aux mangas du genre.", $exception->getMessage(), $exception->getCode());
        }
    }

    public function getGenre($idGenre)
    {
        try {
            return Genre::findOrFail($idGenre);
        } catch (QueryException $exception) {
            throw new UserException("Genre introuvable.", $exception->getMessage(), $exception->getCode());
        }
    }

    public function searchMangas(string $query)
{
    try {
        return Manga::query()
            ->select('manga.*', 'genre.lib_genre', 'dessinateur.nom_dessinateur', 'scenariste.nom_scenariste')
            ->join('genre', 'genre.id_genre', '=', 'manga.id_genre')
            ->join('dessinateur', 'dessinateur.id_dessinateur', '=', 'manga.id_dessinateur')
            ->join('scenariste', 'scenariste.id_scenariste', '=', 'manga.id_scenariste')
            ->where(function ($q) use ($query) {
                $q->where('manga.titre', 'like', "%{$query}%")
                  ->orWhere('dessinateur.nom_dessinateur', 'like', "%{$query}%")
                  ->orWhere('scenariste.nom_scenariste', 'like', "%{$query}%");
            })
            ->get();
    } catch (QueryException $exception) {
        throw new UserException("Impossible d'effectuer la recherche.", $exception->getMessage(), $exception->getCode());
    }
}

}
