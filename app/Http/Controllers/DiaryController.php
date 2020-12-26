<?php

namespace App\Http\Controllers;

use App\Models\DiaryArticleModel;
use App\Models\DiaryCategoryModel;

class DiaryController extends Controller {
    public function index() {
        $articles = DiaryArticleModel::getLatests();
        $headline_categories = DiaryCategoryModel::getHeadlineCategories();

        $calendars = DiaryArticleModel::getCalendars();

        return view('diary.index', [
            'articles'            => $articles,
            'headline_categories' => $headline_categories,
            'calendars'           => $calendars,
        ]);
    }

    public function showArticle($year, $month, $day, $slug) {
        $article = DiaryArticleModel::getArticleByURIParts($year, $month, $day, $slug);
        $calendars = DiaryArticleModel::getCalendars();

        return view('diary.show_article', [
            'article'   => $article,
            'calendars' => $calendars,
        ]);
    }

    public function import() {
        return view('dashboard');
    }
}
