<?php

namespace App\Http\Livewire;

use App\Models\District;
use App\Models\File;
use App\Models\School;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithFileUploads;
use Stevebauman\Purify\Facades\Purify;

class CreateSchool extends Component
{
    use WithFileUploads;

    public ?string $address;
    public ?string $psc;
    public ?string $city;
    public ?string $ico;
    public ?string $izo;
    public ?string $name;
    public ?string $email;
    public ?string $web;
    public ?string $phone;
    public ?string $description;
    public ?int $district_id;
    public $logo; // school logo file
    public $brojure; // school pdf brojure

    protected $rules = [
        'address' => 'required|max:255',
        'psc' => 'required|max:6',
        'city' => 'required|max:255',
        'ico' => 'required|unique:schools,ico|max:10',
        'izo' => 'required|unique:schools,izo|max:11',
        'name' => 'required|max:200',
        'email' => 'required|unique:schools,email|max:255|email',
        'web' => 'required|max:255|url',
        'phone' => 'required|max:255',
        'description' => 'required',
        'district_id' => 'exists:districts,id',
        'logo' => 'image|max:1024', // 1MB Max
        'brojure' => 'nullable|file|max:5120', // 5MB Max
    ];

    public function submit()
    {
        $this->validate();


        DB::transaction(function(){
            $logo_path = $this->logo->store("public/logos");

            $user = Auth::user();

            $sch = School::create([
                'address' => $this->address,
                'psc' => $this->psc,
                'city' => $this->city,
                'ico' => $this->ico,
                'izo' => $this->izo,
                'name' => $this->name,
                'email' => $this->email,
                'web' => $this->web,
                'phone' => $this->phone,
                'description' => Purify::clean($this->description),
                'district_id' => $this->district_id,
            ]);

            File::create([
                'type' => 'logo',
                'name' => substr($logo_path, 6), // strip the public part
                'school_id' => $sch->id
            ]);

            if($this->brojure){
                $brojure_path = $this->brojure->store("public/brojures");

                File::create([
                    'type' => 'brojure',
                    'name' => substr($brojure_path, 6), // strip the public part
                    'school_id' => $sch->id
                ]);
            }

            // images during editing were associated to the user as an intermediary, transfer their ownership to the school
            $user->images()->update([
                'school_id' => $sch->id,
                'user_id' => null
            ]);

            $user->school_id = $sch->id;
            $user->is_main_contact = true;
            $user->push();
        });

        $this->redirect("/dashboard");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.create-school', [
            'districts' => District::orderBy("name")->get(),
        ]);
    }
}
