# practice-sail-laravel9-and-vue

[MEMO.md](/MEMO.md)へのリンク

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

WSL2環境だとdevモードで動かしてもVite開発サーバーへアクセス出来ないのでserverの設定を追加する  
```js
//vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    //追記
    server: {
        host: true,
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});

```

## Vue.js devtoolsのインストール
https://chrome.google.com/webstore/detail/vuejs-devtools/nhdogjmejiglipccpnnnanhbledajbpd?hl=ja

```bash
sail npm run dev
sail artisan serve
```

Vue.js devtoolsで動作を確認する  
開発者モードでVueのタブが表示されていたらOK！
