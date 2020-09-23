<?php

namespace App\Http\Controllers;

use App\Models\Specialization;

class DeleteSpecialization extends Controller
{
    public function __invoke(Specialization $specialization)
    {
        $specialization->delete();

        return redirect(route("dashboard"));
        //
    }
}
