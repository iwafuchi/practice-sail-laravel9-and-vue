# 調べたことや個人的に大事だと感じた事のメモ

## docker-compose.ymlのservice名を変更したい

単純に変更してmigrateするとエラーが発生する

```bash
sail artisan migrate
service "laravel.test" is not running container #1
```

なぜ？  
/vendor/laravel/sail/bin/sailで.envからAPP_SERVICEを取得しており、デフォルトの値がlaravel.testだから！
.envにAPP_SERVICEを追加すればOK！

```.env
APP_SERVICE=your-service
```

## dockerディレクトリの生成
```bash
sail artisan sail:publish
```

## 名前付きルート(named routes)

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InertiaTestController extends Controller
{
    public function index(){
        return Inertia::render('Inertia/Index');
    }
}
```
```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InertiaTestController;

Route::get('/inertia/index', [InertiaTestController::class, 'index'])
    ->name('inertia.index');
```
```vue
<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Link :href="route('inertia.index')">名前付きルートの確認です</Link>
</template>
```

