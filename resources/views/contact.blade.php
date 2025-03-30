@extends('layouts')

@section('content')
    <div class="container pure-g">
        <div class="container-body">
            <div class="card">
                @if (session('success'))
                    <div class="alert success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="pure-form pure-form-stacked">
                    @csrf
                    <fieldset>
                        <legend>お問い合わせフォーム</legend>

                        <div class="form-group">
                            <label for="name">お名前</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="email">返信用メールアドレス（必要な場合）</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="type">お問い合わせ種別</label>
                        </div>
                        <div class="mb-12">
                            <select name="type" id="type" class="form-control form-select" required>
                                <option value="" @if(empty($type)) selected @endif>-</option>
                                <option
                                    value="{{ \App\Enum\ContactType::G->name }}"
                                    @if($type === \App\Enum\ContactType::G) selected @endif
                                >{{ \App\Enum\ContactType::G->value }}</option>
                                <option
                                    value="{{ \App\Enum\ContactType::MBR->name }}"
                                    @if($type === \App\Enum\ContactType::MBR) selected @endif
                                >{{ \App\Enum\ContactType::MBR->value }}</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">メッセージ</label>
                            <textarea
                                id="message"
                                name="message"
                                class="form-control"
                                rows="5"
                                value="{{ old('message') }}"
                                required
                            ></textarea>
                        </div>

                        <div class="cf-turnstile" data-sitekey="0x4AAAAAABDI9oWh9mSdInux" data-callback="javascriptCallback" data-language="ja"></div>

                        <a href="/" class="pure-button button-success">戻る</a>
                        <button type="submit" class="pure-button pure-button-primary">送信</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
