<?php

namespace App\View\Components;

use App\Models\School;
use Illuminate\View\Component;

class SchoolAdminDetail extends Component
{
    public School $school;

    /**
     * SchoolAdminDetail constructor.
     * @param School $school
     */
    public function __construct($school)
    {
        $this->school = $school;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.school-admin-detail');
    }
}
