<?php

namespace App\View\Components;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use const http\Client\Curl\AUTH_ANY;

class RichTextEditor extends Component
{
    private string $label;
    private string $field;

    public function __construct(string $label, string $field)
    {
        $this->label = $label;
        $this->field = $field;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $q = File::where("type", "image");
        if(Auth::user()->school_id == null){
            $q = $q->where("user_id", "=", Auth::user()->id);
        } else{
            $q = $q->where("school_id", "=", Auth::user()->school_id);
        }

        return view('components.rich-text-editor', [
            'label' => $this->label,
            'field' => $this->field,
            'images' => $q->get()
        ]);
    }
}
