<?php

namespace App\Http\Livewire;

use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminImpersonate extends Component
{
    public ?int $user_id;

    function submit()
    {
        if($this->user_id == null)
            return;

        Auth::login(User::findOrFail($this->user_id));

        $this->redirect(route("dashboard"));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.admin-impersonate', [
            'schools' => School::whereIn('schools.id', function($q){
                $q->select("school_id")
                    ->from("users")
                    ->where("is_main_contact", true)
                    ->where("id", "!=", Auth::user()->id);
            })->join("users", "users.school_id", "=", "schools.id")
                ->orderBy("schools.name")
                ->select("schools.name as name", "users.id as user_id")
                ->distinct()
                ->get()
        ]);
    }
}
