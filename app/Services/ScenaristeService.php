<?php

namespace App\Services;

use App\Models\Scenariste;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;

class ScenaristeService
{
    public function getListScenariste()
    {
        try {
            $liste = Scenariste::all();
            return $liste;
        }catch (QueryException $exception){
            $userMessage = "Impossible d'accéder à la base de données.";
            throw new UserException($userMessage, $exception->getMessage(), $exception->getCode());
        }
    }
}
