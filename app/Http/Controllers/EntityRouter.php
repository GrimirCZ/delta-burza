<?php

namespace App\Http\Controllers;

use Auth;

class EntityRouter extends Controller
{
    public function edit()
    {
        $entity = Auth::user()->school;

        if($entity == null){
            return redirect(url("/entita/vytvorit"));
        }

        switch($entity->type()){
            case "school":
                return redirect(url("/skola/upravit"));
            case "company":
                return redirect(url("/spolecnost/upravit"));
            case "empl_dep":
                return redirect(url("/urad_prace/upravit"));
        }

        return abort(404);
    }
}
