<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\RegistrationVisit;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class EnterEventController extends Controller
{
    public function __invoke(string $time, Registration $registration)
    {
        $ip = get_ip();

        if($ip != null){
            RegistrationVisit::create([
                'ip_address' => $ip,
                'type' => $time,
                'registration_id' => $registration->id
            ]);
        }

        $redir_url = $time == 'ranni' ? $registration->morning_event : $registration->evening_event;

        //ensure that the domain starts with http://
        return redirect(fix_url($redir_url));

        //
    }
}
