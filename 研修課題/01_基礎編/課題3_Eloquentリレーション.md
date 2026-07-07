# 課題3｜Eloquentリレーションと Eager Loading

**区分**: 基礎編 ／ **AI利用**: 🚫 **禁止・自力** ／ **想定時間**: 1日

## 目的
生SQLに頼らず、Eloquentのリレーションで結合を表現できるようになる。N+1問題を理解する。

## 🔑 この課題で学ぶLaravel用語
（調べる時のキーワード。「使い方を身につける」対象です）
- **Eloquentリレーション（`hasOne` / `hasMany` / `belongsTo`）** — テーブル間の関連をモデルに定義
- **Eager Loading（`with()`）** — 関連を先読みしてクエリ数を抑える（GORMの `Preload` に相当）
- **N+1問題** — 関連取得でクエリが件数分に増殖する典型的な性能問題
- **クエリログ（`DB::listen` / デバッグバー）** — 発行クエリ本数の観測方法

## 現状の問題
`app/Services/BlogService.php` の `getDetailByTitle()` が生SQLでJOINしている。

```php
DB::select('SELECT * FROM table1 t1
    JOIN table2 t2 ON t1.id = t2.content_id
    WHERE t1.title = ?', [$title]);
```

- `SELECT *` で両テーブルに同名カラム（`id` / `content` / `created_at`）があり、**後勝ちで値が上書きされる潜在バグ**がある。
- Eloquentを完全に迂回しているため、リレーション・キャスト・Resourceの恩恵を受けられない。

## やること
1. `Post` と詳細テーブルの間に **リレーション**（`hasOne` / `hasMany` など適切なもの）を定義。
2. 生SQLを撤去し、`with()` による **Eager Loading** で取得するようリファクタ。
3. わざと一覧でN+1を発生させ、`DB::listen` やログでクエリ本数を観測 → `with()` で解消し、本数が減ることを確認。

## 提出物
- リレーションを定義したモデル
- リファクタ後のService
- 「N+1を観測 → 解消」した際のクエリ本数の before / after メモ

## 受け入れ基準
- [ ] `getDetailByTitle` 相当から生SQLが消えている
- [ ] カラム衝突バグが解消している
- [ ] N+1が起きていない（Eager Loading済み）ことをクエリ本数で示せる

## 学びの確認（口頭・AI禁止課題）
- N+1問題とは何か、なぜ遅いのかを図で説明できるか？
- `SELECT *` のJOINが危険な理由は？
