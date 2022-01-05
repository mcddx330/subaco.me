<?php

namespace App\Http\Controllers;

class IndexController extends Controller {
    public function index() {
        return view(
            'home', [
                'title'   => '秋本すばこ (Subaco Akimoto)',
                'body_id' => 'index',
            ]
        );
    }
}
