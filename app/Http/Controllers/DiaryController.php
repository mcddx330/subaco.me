<?php

namespace App\Http\Controllers;

class DiaryController extends Controller {
    public function index() {
        return view('diary.index');
    }
}
