<?php

namespace App\Http\Livewire;

use App\Models\School;
use Livewire\Component;

class SchoolInterest extends Component
{
    public School $school;

    public ?string $name;
    public ?string $email;
    public ?string $phone;
    public ?string $body;

    public ?bool $gdpr;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.school-interest');
    }
}
