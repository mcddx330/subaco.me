<?php

namespace App\Http\Controllers;

use App\Enum\ContactType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller {
    public function index() {
        return view(
            'home', [
                'title' => '秋本すばこ (Subaco Akimoto)',
                'body_id' => 'index',
            ]
        );
    }

    public function contact(Request $request) {
        $type = strtoupper($request->get('t', ''));
        switch (true) {
            case ($type === ContactType::G->name):
                $type = ContactType::G;
                break;
            case ($type === ContactType::MBR->name):
                $type = ContactType::MBR;
                break;
            default:
                $type = null;
                break;
        }
        return view(
            'contact', [
                'title' => 'お問い合わせ',
                'body_id' => 'contact',
                'type' => $type,
            ]
        );
    }

    public function submitContact(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string',
            'type' => 'required|not_in:""', // typeが空選択肢でないことを確認
        ], [
            'required' => ':attribute が入力されていません。',
        ], [
            'name' => 'お名前',
            'email' => '返信用メールアドレス',
            'message' => 'メッセージ',
            'type' => 'お問い合わせ種別',
        ]);


        $type = strtoupper($request->get('type'));
        switch (true) {
            case ($type === ContactType::MBR->name):
                $type = ContactType::MBR;
                break;
            default:
                $type = ContactType::G;
                break;
        }

        $data = $request->only(['name', 'email', 'message', 'type']);
        $data['type'] = $type;

        $webhook_url = env('DISCORD_WEBHOOK_URL');
        try {
            $response = Http::post($webhook_url, [
                'content' => view('contact.body', $data)->render(),
            ]);
            if (!$response->successful()) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            Session::flash('error', 'お問い合わせ内容の送信に失敗しました。');
            return redirect(route('contact'))->withInput();
        }

        Session::flash('success', 'お問い合わせ内容を送信しました。');
        return redirect(route('contact'));
    }
}
