@extends('layouts')

@section('content')
    <div class="container">
        <div class="container-body">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="pm0 pd1 contents">
                    <h1>お問い合わせ</h1>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf

                        <div class="mb-12">
                            <label for="name" class="form-label">名前</label>
                        </div>
                        <div class="mb-12">
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <div class="mb-12">
                            <label for="email" class="form-label">返信用メールアドレス</label>
                        </div>
                        <div class="mb-12">
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-12">
                            <label for="type" class="form-label">お問い合わせ種類</label>
                        </div>
                        <div class="mb-12">
                            <select name="type" id="type" class="form-control form-select" required>
                                <option value="" @if(empty($type)) selected @endif>-</option>
                                <option
                                    value="{{ \App\Enum\ContactType::G->name }}"
                                    @if($type === \App\Enum\ContactType::G) selected @endif
                                >{{ \App\Enum\ContactType::G->value }}</option>
                                <option
                                    value="{{ \App\Enum\ContactType::MB->name }}"
                                    @if($type === \App\Enum\ContactType::MB) selected @endif
                                >{{ \App\Enum\ContactType::MB->value }}</option>
                            </select>
                        </div>

                        <div class="mb-12">
                            <label for="message" class="form-label">お問い合わせ内容</label>
                        </div>
                        <div class="mb-12">
                            <textarea name="message" id="message" class="form-control" rows="5" required></textarea>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">送信</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
