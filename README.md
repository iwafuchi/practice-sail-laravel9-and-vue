# practice-sail-laravel9-and-vue

## sailでプロジェクトを作成

```bash
curl -s https://laravel.build/practice-sail-laravel9-and-vue3 | bash
cd practice-sail-laravel9-and-vue3
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
sail up -d
```

## laravel Breezeのインストール
```php
sail composer require laravel/breeze --dev
```

## vueのインストール
```php
sail artisan breeze:install vue
```