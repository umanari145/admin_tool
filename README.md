# admin_admin
管理ツール

### テスト対策

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
```
cp .env.dev .env
php artisan key:generate
```


### CDパイプラインに関する記載

circleci\config.ymlに関して<br>
トリガーがpush時というのはおそらくdefaultの設定
```
version: 2.1

jobs:
  // jobs名はbuildだとpush時に動くがそうでないと動かないので注意
  build:
    // 仮想環境上で動くdocker-image
    docker:
      - image: circleci/php:7.3-node-browsers
    // 具体的な処理の記載  
    steps:
      // githubからソースをとってくる(ほぼ全ての処理で書く)
      - checkout
      // composer updateを行う
      - run: sudo composer self-update --1
      // 時間かかるのでcacheを使用 {{ checksum "composer.lock" }}はハッシュ値にする関数 circleCIから正常にキャッシュがダウンロードされていることを確認
      - restore_cache:
          key: composer-v1-{{ checksum "composer.lock" }}
      // -nはyes no のやりとりを発生させない --prefer-distは高速化対応(zip?)
      - run: composer install -n --prefer-dist 
      // 先程のcache対応
      - save_cache:
          key: composer-v1-{{ checksum "composer.lock" }}
          paths: 
            - vendor
      // npmもcomposerと全く同様      
      - restore_cache:
          key: node-v1-{{ checksum "package.json" }}
      - run: npm install
      - save_cache:
          key: node-v1-{{ checksum "package.json" }}
          paths: 
            - node_modules


```