<?php

namespace App\Http\Controllers;

use App\Models\DiaryArticleModel;
use App\Models\DiaryCategoryModel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DiaryController extends Controller {
    public function index() {
        $articles = DiaryArticleModel::getLatests();
        $headline_categories = DiaryCategoryModel::getHeadlineCategories();

        $calendars = DiaryArticleModel::getCalendars();

        return view('diary.index', [
            'title'               => 'diary',
            'body_id'             => 'diary',
            'articles'            => $articles,
            'headline_categories' => $headline_categories,
            'calendars'           => $calendars,
        ]);
    }

    public function showArticle($ymd, $slug) {
        $article = DiaryArticleModel::getArticleByURIParts($ymd, $slug);
        $calendars = DiaryArticleModel::getCalendars();

        if (!($article instanceof DiaryArticleModel)) {
            throw new NotFoundHttpException();
        }

        return view('diary.show_article', [
            'article'   => $article,
            'calendars' => $calendars,
        ]);
    }

    public function import() {
        return view('dashboard');
    }
}
