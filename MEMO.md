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

## createInertiaApp
app.jsでimportされている。  
resoleveプロパティで/resources/js/Pages配下のvueファイルを探しに行っている。
このおかげでvueファイルのパスを解決出来ている。

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

## Linkルートパラメータ
ルートパラメータを付与して遷移
```php
//InertiaTestController
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class InertiaTestController extends Controller {
    public function show($id) {
        return Inertia::render('Inertia/Show', ['id' => $id]);
    }
}

```

```php
//web.php
Route::get('/inertia/show{id}', [InertiaTestController::class, 'show'])
    ->name('inertia.show');
```

```vue
<!-- InertiaTest.vue -->
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <!-- パラメータはオブジェクト形式 -->
    <Link :href="route('inertia.show', { id: 50 })">ルートパラメータのテストです</Link>
</template>

```

```vue
<!-- Show.vue -->
<script setup>
// definePropsでパラメータを取得
defineProps({
    id: String
})
</script>

<template>
    {{ id }}
</template>
```

## Requestを受け取る時
```php
// 受け取りたい値のみ取得する
$attributes = $request->only('title', 'content');
```

## postメソッドでのルートにLinkで遷移する場合はmethod='post'を指定する
```php
Route::post('/inertia', [InertiaTestController::class, 'store'])
    ->name('inertia.store');
```

```vue
    <Link as="button" method="post" :href="route('inertia.store')" :data="{
        title: newTitle,
        content: newContent
    }">
    DB保存テスト
    </Link>
```

## DBに保存する場合は、書き換え可能なカラムをfillableで指定する
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InertisaTest extends Model {
    use HasFactory;

    protected $fillable = ['title', 'content'];
}
```

## Vue.js SingleFileComponent

HTML + JS + CSSを1つのファイル(*.vue)にまとめることが出来る特別なファイル形式  
\<template>と\<script>と\<style>の3種類の言語ブロックで構成されている。  
\<script>セクションは、標準的なJavascriptモジュールです。Vueコンポーネント定義をデフォルトでエクスポートする必要がある。  
\<template>セクションは、コンポーネントのテンプレートを定義する。  
\<style>セクションは、コンポーネントに関連するCSSを定義する。  

```vue
<script>
export default {
  data() {
    return {
      greeting: 'Hello World!'
    }
  }
}
</script>

<template>
  <p class="greeting">{{ greeting }}</p>
</template>

<style>
.greeting {
  color: red;
  font-weight: bold;
}
</style>
```

よく使うディレクティブ
v-if,v-else,v-else-if  
v-for(v-for in),v-show  
v-text,v-html  
v-on(省略形は@) イベント  
v-bind(省略形は:) 紐づけ  
v-model フォーム用  
v-cloak  
v-slot  
トランジション関連
