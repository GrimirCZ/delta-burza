<?php

namespace App\Http\Livewire;

use App\Article;
use App\Models\Exhibition;
use App\Models\School;
use Livewire\Component;

class Index extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.index', [
            "schoolsCount" => School::where('is_school', 1)->count(),
            "companiesCount" => School::where('is_school', 0)->count(),
            'exibitionsCount' => Exhibition::count(),
            'articles' => Article::where("show", true)->orderByDesc("date")->get(),
            'upcoming_exhibitions' => Exhibition::orderBy("date")->limit(4)->get()
        ]);
    }
}
