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
    ];

    public function submit()
    {
        $this->validate();


        DB::transaction(function(){
            $logo_path = $this->logo->store("public/logos");

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
                'description' => $this->description,
                'district_id' => $this->district_id,
            ]);

            File::create([
                'type' => 'logo',
                'name' => substr($logo_path, 6), // strip the public part
                'school_id' => $sch->id
            ]);

            Auth::user()->school_id = $sch->id;
            Auth::user()->is_main_contact = true;
            Auth::user()->push();
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
