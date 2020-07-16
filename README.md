# career-board
経歴の一覧機能

## 必要なもの

* Docker

## laradock導入手順

プロジェクト
∟laradock
∟プロジェクト（laravel）フォルダ
になるように設定していきます。

### laradockの導入
```
$ mkdir {プロジェクト}
$ cd {プロジェクト}
$ git clone https://github.com/Laradock/laradock.git
$ cd laradock
$ cp env-example .env
$ cd nginx/sites/
$ vim default.conf
```
キーボードのiを押してVimをインサートモードに
```
root /var/www/public;
```
上記の箇所を
```
root /var/www/{プロジェクト（laravel）フォルダ}/public;
```
に変更
キーボードのescを押して、
:wq（保存して終了）
laradockフォルダ上まで戻る

### dockerの起動
```
$ docker-compose up -d nginx mysql phpmyadmin
```
※ここでdocker-compose up -d だけで起動すると必要のないコンテナまで立ち上げてしまい死ぬほど時間かかるので
必ずnginx mysql phpmyadminこの3つを指定して立ち上げてください。

### workspace（コンテナ）へ入る
```
$ docker-compose exec --user=laradock workspace bash
```

### 既存プロジェクトのクローン
```
$ git clone {project_repository}
$ exit
$ docker-compose stop
```

### laradock側の.envの編集
クローンしたフォルダ名を指定してしてください
```
APP_CODE_PATH_HOST=../{プロジェクト（laravel）フォルダ}
APP_CODE_PATH_CONTAINER=/var/www/{プロジェクト（laravel）フォルダ}
```

### laravel側の.envの編集
クローンしたlaravelプロジェクト内で
```
$ cp .env.example .env
```
DB情報をlaradockと一致させます。
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=default
DB_USERNAME=default
DB_PASSWORD=secret
```
に変更してください

### 起動しコンテナの中で必要なものをインストール
```
$ docker-compose up -d nginx mysql phpmyadmin
$ docker-compose exec --user=laradock workspace bash
$ composer install
$ npm install
$ php artisan key:generate
$ php artisan migrate:fresh --seed
$ exit
$ docker-compose restart
```

### アクセス
- 以下のURLにアクセスし、画面が正常に表示されることの確認
【http://localhost】

### 注意事項
- migrationやseederなどはコンテナの中に入って実行してください。
- npm run devなどはlaravelプロジェクト配下で実行してください。
- dockerコマンドはlaradock配下で実行してください。