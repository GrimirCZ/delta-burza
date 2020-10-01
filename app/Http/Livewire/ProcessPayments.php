<?php

namespace App\Http\Livewire;

use App\Imports\PaymentImport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Excel;

class ProcessPayments extends Component
{
    use WithFileUploads;

    public $platby;
    public $output;

    protected $rules = [
        'platby' => 'required|file|max:5120'
    ];

    public function mount()
    {
        if(!Auth::user()->is_admin){
            return abort(401);
        }
    }

    public function submit()
    {
        $this->validate();

        $file_path = $this->platby->storePublicly("imports");

        (new PaymentImport())->import($file_path, "local", Excel::CSV);
    }

    public function download_results()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.process-payments');
    }
}
