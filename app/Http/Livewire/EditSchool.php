<?php

namespace App\Http\Livewire;

use App\Models\District;
use App\Models\File;
use App\Models\School;
use Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditSchool extends Component
{
    use WithFileUploads;

    public School $school;

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
        'district_id' => 'exists:districts,id',
        'logo' => 'image|max:1024', // 1MB Max
    ];

    public function submit()
    {
        $this->validate();


        DB::transaction(function(){
            $logo_path = $this->logo->store("public/logos");

            $this->school->update([
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
                'name' => substr($logo_path, 6), // strip the public part
                'school_id' => $this->school->id
            ]);
        });

        $this->redirect("/dashboard");
    }

    public function mount(School $school)
    {
        $this->school = $school;
        $this->address = $school->address;
        $this->ico = $school->ico;
        $this->izo = $school->izo;
        $this->name = $school->name;
        $this->email = $school->email;
        $this->web = $school->web;
        $this->phone = $school->phone;
        $this->description = $school->description;
        $this->district_id = $school->district_id;
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
