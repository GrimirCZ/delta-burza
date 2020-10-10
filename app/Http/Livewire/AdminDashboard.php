<?php

namespace App\Http\Livewire;

use App\Article;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function deleteArticle(int $article_id)
    {
        Article::findOrFail($article_id)->delete();
    }


    public function hideArticle(int $article_id)
    {
        $article = Article::findOrFail($article_id);

        $article->show = false;

        $article->push();
    }

    public function showArticle(int $article_id)
    {
        $article = Article::findOrFail($article_id);

        $article->show = true;

        $article->push();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('livewire.admin-dashboard', [
            'articles' => Article::orderBy("date")->get()
        ]);
    }
}
