<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view("dashboard", [
            'school'=> Auth::user()->school,
            'unnasociated_schools_exist' => School::unassociated_schools()->exists(),
        ]);
        //
    }
}
