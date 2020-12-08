<?php

namespace App\Http\Livewire;

use App\Models\District;
use App\Models\File;
use App\Models\School;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditSchool extends Component
{
    use WithFileUploads;

    public School $school;

    public ?string $address = null;
    public ?string $psc = null;
    public ?string $city = null;
    public ?string $ico = null;
    public ?string $izo = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $web = null;
    public ?string $phone = null;
    public ?string $description = null;
    public ?int $district_id = null;
    public $logo = null; // school logo file
    public $brojure = null; // school pdf brojure

    public function submit()
    {
        $this->validate([
            'address' => 'required|max:255',
            'psc' => 'required|max:6',
            'city' => 'required|max:255',
            'ico' => [
                'required',
                'max:10',
                Rule::unique("schools", "ico")->ignore($this->school->id),
            ],
            'izo' => [
                'required',
                'max:11',
                Rule::unique("schools", "izo")->ignore($this->school->id),
            ],
            'name' => 'required|max:500',
            'email' =>
                [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique("schools", "email")->ignore($this->school->id),
                ],
            'web' => 'required|max:255|url',
            'phone' => 'required|max:255',
            'description' => 'required',
            'district_id' => 'exists:districts,id',
            'logo' => 'nullable|sometimes|image|max:1024', // 1MB Max
            'brojure' => 'nullable|sometimes|file|max:5120', // 5MB Max
        ]);


        DB::transaction(function(){

            $this->school->update([
                'address' => $this->address,
                'psc' => $this->psc,
                'city' => $this->city,
                'ico' => $this->ico,
                'izo' => $this->izo,
                'name' => trim($this->name),
                'email' => $this->email,
                'web' => $this->web,
                'phone' => $this->phone,
                'description' => html_clean($this->description),
                'district_id' => $this->district_id,
            ]);

            if($this->logo){
                $filename = $this->logo->storePublicly("logos", 's3');
                $logo_path = Storage::disk("s3")->url($filename);


                File::where("school_id", $this->school->id)->where("type", "logo")->delete();

                File::create([
                    'type' => 'logo',
                    'name' => $logo_path, // strip the public part
                    'school_id' => $this->school->id
                ]);
            }

            if($this->brojure){
                $s3 = Storage::disk("s3");

                $path = $s3->url($this->brojure->getClientOriginalName());

                $ext = pathinfo($path, PATHINFO_EXTENSION);

                $filename = "brojures/" . rand_str(32) . ".$ext";

                $s3->getDriver()->put($filename, file_get_contents($path), [
                    'visibility' => 'public',
                    'ContentDisposition' => "attachment; filename=\"$this->name brožura.$ext\""
                ]);

                $brojure_path = $s3->url($filename);

                File::where("school_id", $this->school->id)->where("type", "brojure")->delete();

                File::create([
                    'type' => 'brojure',
                    'name' => $brojure_path, // strip the public part, wtf
                    'school_id' => $this->school->id
                ]);
            }
        });

        $this->redirect("/dashboard");
    }

    public function mount()
    {
        $school = Auth::user()->school;
        $this->school = $school;
        $this->address = $school->address;
        $this->psc = $school->psc;
        $this->city = $school->city;
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
            'edit' => true,
            'type_of_exhibitioner' => 'school'
        ]);
    }
}
