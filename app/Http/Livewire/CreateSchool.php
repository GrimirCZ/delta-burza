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
        'ico' => 'required|max:10',
        'izo' => 'required|max:11',
        'name' => 'required|max:200',
        'email' => 'required|max:255|email',
        'web' => 'required|max:255|url',
        'phone' => 'required|max:255',
        'description' => 'required',
        'district_id' => 'required|exists:districts,id',
        'logo' => 'image|max:1024', // 1MB Max
    ];

    public function submit()
    {
        $this->validate();


        DB::transaction(function(){
            $logo_path = $this->logo->store("public/logos");

            $sch = School::create([
                'address' => $this->address,
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
                'name' => $logo_path,
                'school_id' => $sch->id
            ]);

            Auth::user()->school_id = $sch->id;
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
