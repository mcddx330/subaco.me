<?php

namespace App\Http\Controllers;

use App\Enum\ContactType;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller {
    public function index() {
        return view(
            'home', [
                'title'   => '秋本すばこ (Subaco Akimoto)',
                'body_id' => 'index',
            ]
        );
    }

    public function contact(Request $request) {
        $type = strtoupper($request->get('t', ''));
        switch (true) {
            case ($type === ContactType::G->name): $type = ContactType::G; break;
            case ($type === ContactType::MB->name): $type = ContactType::MB; break;
            default: $type = null; break;
        }
        return view(
            'contact', [
                'title'   => 'お問い合わせ',
                'body_id' => 'contact',
                'type' => $type,
            ]
        );
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'type' => 'required|not_in:""', // typeが空選択肢でないことを確認
        ], [
            'type.not_in' => 'お問い合わせの種類を選択してください。', // エラーメッセージ
        ]);

        $type = strtoupper($request->get('type'));
        switch (true) {
            case ($type === ContactType::MB->name): $type = ContactType::MB; break;
            default: $type = ContactType::G; break;
        }

        $data = $request->only(['name', 'email', 'message', 'type']);
        $data['type'] = $type;
        Mail::to('admin@example.com')->send(new ContactMail($data));

        return redirect(route('contact'))->with('success', 'お問い合わせ内容を送信しました');
    }
}
