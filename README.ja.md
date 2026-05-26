# 📋 DocFlow 文書管理システム

> 多段階レビュー機能を備えたWebベースの文書ワークフロー管理システム — **Laravel 12** と **MySQL** で構築。

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

---

## 📖 プロジェクト概要

**DocFlow 文書管理システム**は、組織内における文書の申請・レビュー・承認プロセスを多段階ワークフローで管理するWebアプリケーションです。本システムは、Pankaj Jalote著 *A Concise Introduction to Software Engineering*（Springer、2008年）に基づく*反復型ソフトウェア開発*手法を採用して設計されました。

### 背景

メールや紙による手動の文書管理は、処理の遅延・文書の紛失・ステータスの不透明さを招きがちです。DocFlow は、レビューフローを自動化し、関係者全員が進捗を把握できる可視性を提供し、すべての操作を監査ログとして記録するデジタルソリューションです。

---

## ✨ 主な機能

### 👤 マルチロール ユーザー管理
- **3種類のユーザーロール:** ユーザー（User）、レビュアー（Reviewer）、管理者（Admin）
- 管理者による承認付きアカウント登録
- プロフィールおよび所属部署の管理

### 📄 文書管理
- 文書の作成・下書き保存・編集・削除
- ファイル添付のアップロード（PDF、Word、Excel など）
- レビューフローを開始するための文書提出
- 文書ステータスの変更履歴の閲覧

### 🔄 多段階レビューワークフロー
- 多段階レビューパイプライン（レベル1 → レベル2 → 管理者承認）
- 各レビュアーは自分のレベルに割り当てられた文書のみを閲覧可能
- レビュアーのアクション: **承認（Approve）**、**却下（Reject）**、**修正依頼（Request Revision）**
- 修正が必要な場合は文書がユーザーに差し戻し

### 🔔 通知 & 監査ログ
- ステータス変更ごとのリアルタイム通知
- 完全な監査ログ: すべての操作をIPアドレスとタイムスタンプとともに記録
- レビュー履歴は `review_logs` テーブルに保存

### 📊 ロール別ダッシュボード
- **ユーザー:** 文書ステータス、未提出の下書き、提出履歴
- **レビュアー:** レビュー待ち文書のキュー、締め切り管理
- **管理者:** システム全体の文書モニタリング、ユーザー管理、最終アーカイブ

### 🗄️ アーカイブ & レポート
- 承認済み文書は自動的にアーカイブへ移動
- ステータス・種別・期間によるフィルタリングと検索

---

## 🗂️ 文書ステータス遷移図

```
下書き → 提出済み → レビュー中（Lv1）→ レビュー中（Lv2）→ 管理者承認 → アーカイブ
                        ↓                      ↓                   ↓
                    修正依頼              修正依頼              却下（Rejected）
                        ↓
                  （ユーザーへ差し戻し）
```

---

## 🗃️ データベーススキーマ

| テーブル               | 説明                                               |
|------------------------|----------------------------------------------------|
| `users`                | ユーザー情報（ロール、ステータス、所属部署）       |
| `documents`            | 文書メインレコード + ステータス + current_level    |
| `document_attachments` | 文書ごとの添付ファイル                             |
| `review_logs`          | 各レベルにおけるレビュアーの操作履歴               |
| `notifications`        | ユーザーごとの通知                                 |
| `audit_logs`           | システム全体の操作ログ                             |

---

## 🛠️ 技術スタック

| コンポーネント | 技術                       |
|----------------|----------------------------|
| バックエンド   | Laravel 12（PHP 8.2+）     |
| データベース   | MySQL 8.0                  |
| フロントエンド | Blade + Tailwind CSS       |
| 認証           | Laravel Breeze / Sanctum   |
| キュー         | Laravel Queue + Supervisor |
| スケジューラー | Laravel Scheduler（Cron）  |
| テスト         | PHPUnit + Laravel Dusk     |

---

## ⚙️ インストール手順（ローカル開発）

### 必要環境
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0
- Git

### 手順

```bash
# 1. リポジトリをクローン
git clone https://github.com/aryaxsurya/docflow-management-system.git
cd docflow-management-system

# 2. PHP依存パッケージのインストール
composer install

# 3. Node.js依存パッケージのインストール
npm install && npm run build

# 4. 環境ファイルのコピー
cp .env.example .env

# 5. アプリケーションキーの生成
php artisan key:generate

# 6. .env でデータベースを設定
# DB_DATABASE=docflow
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 7. マイグレーションとシーダーの実行
php artisan migrate
php artisan db:seed --class=AdminUserSeeder

# 8. ストレージシンリンクの作成
php artisan storage:link

# 9. 開発サーバーの起動
php artisan serve
```

アクセス先: `http://localhost:8000`

### デフォルトアカウント（シーダー）
| ロール   | メールアドレス           | パスワード |
|----------|--------------------------|------------|
| Admin    | admin@docflow.test       | password   |
| Reviewer | reviewer@docflow.test    | password   |
| User     | user@docflow.test        | password   |

---

## 🚀 デプロイ（本番環境）

```bash
# サーバーへクローン後
composer install --optimize-autoloader --no-dev
npm install && npm run build
cp .env.example .env
php artisan key:generate

# .env を編集: APP_ENV=production、APP_DEBUG=false、DB情報を設定

php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder --force

# キャッシュ最適化
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link

# パーミッション設定
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data .
```

---

## 🧪 テスト

```bash
# 全テストの実行
php artisan test

# 特定のテストを実行
php artisan test --filter DocumentWorkflowTest

# カバレッジレポートの生成
php artisan test --coverage
```

---

## 📁 フォルダ構成

```
docflow-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # AuthController, DocumentController, ReviewController, AdminController
│   │   └── Requests/          # フォームリクエストバリデーション
│   ├── Models/                # User, Document, ReviewLog, AuditLog など
│   ├── Services/              # DocumentService, ReviewService（ビジネスロジック）
│   ├── Policies/              # ロールベースの認可
│   └── Events/ & Listeners/   # 通知 & 監査ログ（疎結合）
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/                 # ロール別 Blade テンプレート
├── routes/
│   └── web.php
└── tests/
    ├── Unit/
    └── Feature/
```

---

## 📋 開発手法

本プロジェクトは Jalote の方法論に基づく **8フェーズの反復型ソフトウェア開発** に従っています:

| フェーズ | 活動内容                            | 期間           |
|----------|-------------------------------------|----------------|
| 1        | 要件分析 & SRS                      | 3〜5日         |
| 2        | プロジェクト計画（見積・リスク管理）| 2〜3日         |
| 3        | アーキテクチャ & データベース設計   | 3〜4日         |
| 4        | 環境構築 & スキャフォールディング   | 1〜2日         |
| 5        | コアモジュール実装                  | 15〜20日       |
| 6        | テスト & 品質保証                   | 5〜7日         |
| 7        | デプロイ & 本番稼働                 | 2〜3日         |
| 8        | 保守 & 次回イテレーション           | 継続的          |

**総見積工数: 約35〜45営業日**

---

## 🤝 コントリビューション

本プロジェクトは学術課題として開発されました。改善案やフィードバックは [Issues](https://github.com/aryaxsurya/docflow-management-system/issues) からお気軽にどうぞ。

---

## 📜 ライセンス

本プロジェクトは [MIT ライセンス](LICENSE) のもとで公開されています。

---

## 👤 作者

**Arya Surya**  
GitHub: [@aryaxsurya](https://github.com/aryaxsurya)

---

> *本プロジェクトは A Concise Introduction to Software Engineering — Pankaj Jalote（Springer、2008年）に基づいて構築されました。*
