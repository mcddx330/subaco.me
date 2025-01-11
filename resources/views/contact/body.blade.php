## お問い合わせ内容

### お名前：
{{ nl2br(e($name)) }}
### メールアドレス：
@isset($email)
{{ e($email) }}
@else
（なし）
@endisset
### 種類：
{{ $type->value }}
### メッセージ：
```
{{ e($message) }}
```
