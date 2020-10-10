<?php

namespace App\Http\Livewire;

use App\Article;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class AdminArticleEdit extends Component
{
    public ?Article $article;
    public ?string $title;
    public ?string $content;

    protected $rules = [
        'title' => 'required|max:512',
        'content' => 'required'
    ];

    public function submit()
    {
        $this->validate();

        $this->article->update([
            'title' => $this->title,
            'content' => $this->content
        ]);

        return $this->redirect('/admin');
    }

    public function mount(Article $article)
    {
        $this->article = $article;
        $this->title = $this->article->title;
        $this->content = $this->article->content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.admin-article-create', [
            'edit' => true
        ]);
    }
}
