<?php

namespace App\Http\Controllers;

use App\Models\School;
use Auth;

class UnlinkSchoolFromCompany extends Controller
{
    public function __invoke(School $school)
    {
        Auth::user()->school->related_schools()->detach($school);

        return redirect(route("dashboard"));
    }
}
