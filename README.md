# kantan_wms_admin
管理ツール

### テスト対策
セットアップ用(ローカル開発時テストDB構築)
```
./vendor/bin/phpunit ./tests/Start/StartTest.php 
#内部でphp artisan migrate:refresh --seedを実行
```

個別テスト(個別ファイル)
```
./vendor/bin/phpunit ./tests/*****/**** 
```

全パターンテスト
```
./vendor/bin/phpunit
```

vueの開発
```
npm run watch
```

### migration
```
#migration実行
docker exec kad_php php artisan migrate 
docker exec kad_php php artisan db:seed

#下記コマンドで一気に初期化(全drop)&migrationデータ入力
#docker exec kad_php php artisan migrate:refresh --seed


#テンプレートファイル作成
#新規
php artisan make:migration [migrationファイル名] --create=[新規テーブル作成]
＃既存変更
php artisan make:migration [migrationファイル名] --table=[既存テーブル作成]
```

### デプロイ時
cp .env.dev .env
php artisan key:generate