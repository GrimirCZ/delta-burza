<?php

namespace App\Http\Livewire;

use App\Article;
use App\Models\District;
use App\Models\EntityType;
use App\Models\File;
use App\Models\School;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\WithFileUploads;

class CreateSchool extends Component
{
    use WithFileUploads;

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

    public $type_of_exhibitioner = "company";

    public function updated($name, $value)
    {
        if($name == "type_of_exhibitioner" && $value == "empl_dep"){
            $empl_dep_desc_template = Article::find(1001);
            if($empl_dep_desc_template != null){
                $this->ico = "724 96 991";
                $this->description = $empl_dep_desc_template->content;

                $this->dispatchBrowserEvent('description-updated', ['content' => $this->description]);
            }
        }

    }

    public function submit()
    {
        $this->validate([
            'address' => 'required|max:255',
            'psc' => 'required|max:6',
            'city' => 'required|max:255',
            'ico' => 'sometimes|max:10',
            'izo' => [
                Rule::requiredIf($this->type_of_exhibitioner == "school"),
                'nullable',
                'unique:schools,izo',
                'max:11'
            ],
            'name' => 'required|max:500',
            'email' => 'required|unique:schools,email|max:255|email',
            'web' => 'required|max:255|url',
            'phone' => 'required|max:255',
            'description' => 'required',
            'district_id' => 'exists:districts,id',
            'type_of_exhibitioner' => 'exists:entity_types,type',
            'logo' => 'nullable|image|max:1024', // 1MB Max
            'brojure' => 'nullable|sometimes|file|max:5120', // 5MB Max
        ]);


        DB::transaction(function(){

            $user = Auth::user();

            $et_id = EntityType::get($this->type_of_exhibitioner)->id;

            $sch = School::create([
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
                'entity_type_id' => $et_id
            ]);

            if($this->type_of_exhibitioner == "empl_dep"){
                File::create([
                    'type' => 'logo',
                    'name' => url("/images/up.png"), // strip the public part
                    'school_id' => $sch->id
                ]);
            } else if($this->logo){
                $filename = $this->logo->storePublicly("logos", 's3');
                $logo_path = Storage::disk("s3")->url($filename);

                File::create([
                    'type' => 'logo',
                    'name' => substr($logo_path, 6), // strip the public part
                    'school_id' => $sch->id
                ]);
            } else{
                File::create([
                    'type' => 'logo',
                    'name' => "#",
                    'school_id' => $sch->id
                ]);
            }

            if($this->brojure){
                $s3 = Storage::disk("s3");

                $ext = pathinfo($this->brojure->getClientOriginalName(), PATHINFO_EXTENSION);

                $filename  = "brojures/" .  rand_str(32) . ".$ext";

                $s3->getDriver()->put($filename, $s3->get($this->brojure->getRealPath()), [
                    'visibility' => 'public',
                    'ContentDisposition' => "attachment; filename=\"$this->name brožura.$ext\""
                ]);

                $brojure_path = $s3->url($filename);

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
            'create' => true
        ]);
    }
}
