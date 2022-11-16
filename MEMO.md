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

## Vue.js CompositionAPI(setup)

```vue
<script setup>
import {Link} from '@inertia/inertia-vue3' //inertia側
import {ref} from 'vue' //vue側

//コントローラからの受け渡し
defineProps({
    id: String
})
//リアクティブな変数はrefかreactiveで囲む
const reactiveVariable = ref('');
</script>

<template>
<input type="text" name="reactiveVariable" v-model="reactiveVariable">{{reactiveVariable}}
</template>
```

## inertiaでformを利用する
```vue
<script setup>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

//formのパラメータを設定する
const form = reactive({
    title: null,
    content: null,
})

//submitを実行した際にpostメソッドを実行し/inertiaへ遷移する
const submitFunction = () => {
    Inertia.post('/inertia', form)
};
</script>
<template>
    <!-- submitを実行した際の挙動を設定 -->
    <form @submit.prevent="submitFunction">
        <input type="text" name="title" v-model="form.title"><br>
        <input type="text" name="content" v-model="form.content"><br>
        <button>送信</button>
    </form>
</template>
```

## langのvalidationで個別に属性を翻訳する

```php
//lang/ja/validation.php

<?php

declare(strict_types=1);

return [
    //省略
        'attributes' => [
        'title' => 'タイトル',
        'content' => '本文'
        ]
];
```
titleは必須項目です。→タイトルは必須項目です。

## バックエンドのバリデートエラーを表示する

```vue
<script setup>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    errors: Object
})

const form = reactive({
    title: null,
    content: null,
})

const submitFunction = () => {
    Inertia.post('/inertia', form)
};
</script>
<template>
    <form @submit.prevent="submitFunction">
        <input type="text" name="title" v-model="form.title"><br>
        <!-- v-ifでerrors.titleプロパティが存在する場合のみ表示する -->
        <div v-if="errors.title">{{ errors.title }}</div>
        <input type="text" name="content" v-model="form.content"><br>
        <!-- v-ifでerrors.contentプロパティが存在する場合のみ表示する -->
        <div v-if="errors.content">{{ errors.content }}</div>
        <button>送信</button>
    </form>
</template>
```

## CSRF対策
Laravel @csrfで対応  
Inertia 既に対応されている(X-XSRF-TOKEN)  

## Inertiaでフラッシュメッセージを表示する

```php
//HandleInertiaRequests.php
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware {
    //省略

    //Shared dataにフラッシュメッセージを追加する
    public function share(Request $request) {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            //フラッシュメッセージを追加
            'flash' => [
                'message' => fn () => $request->session()->get('message')
            ],
        ]);
    }
}
```

```php
//Controller
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\InertisaTest;
use App\Http\Requests\InertiaTestStoreRequest;

class InertiaTestController extends Controller {
    public function index() {
        return Inertia::render('Inertia/Index');
    }
    public function create() {
        return Inertia::render('Inertia/Create');
    }
    public function show($id) {
        return Inertia::render('Inertia/Show', ['id' => $id]);
    }
    public function store(InertiaTestStoreRequest $request) {
        $inertiaTest = new InertisaTest();
        $attributes = $request->only('title', 'content');
        $inertiaTest->fill([
            'title' => $attributes['title'],
            'content' => $attributes['content']
        ])->save();
        //フラッシュメッセージを設定
        return to_route('inertia.index')
            ->with([
                'message' => '登録しました。'
            ]);
    }
}
```

```vue
<script setup>
</script>

<template>
    <!-- フラッシュメッセージを表示する -->
    <div v-if="$page.props.flash.message">
        {{ $page.props.flash.message }}
    </div>
</template>
```

## v-forを使用する

```php
//model
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inertisa_tests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('inertisa_tests');
    }
};
```

```php
//controller
<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\InertisaTest;
use App\Http\Requests\InertiaTestStoreRequest;

class InertiaTestController extends Controller {
    public function index() {
        return Inertia::render('Inertia/Index', [
            'blogs' => InertisaTest::all()
        ]);
    }
}
```

```vue
<script setup>
import { Link } from '@inertiajs/inertia-vue3';

defineProps({
    blogs: Array
})
</script>

<template>
    <div v-if="$page.props.flash.message" class="bg-blue-300">
        {{ $page.props.flash.message }}
    </div>
    <ul>
        <!-- 単数形 in 複数形のフォーマットで記載する
            key 属性を付与し、要素とデータを関連付けることを忘れずに
         -->
        <li v-for="blog in blogs" :key="blog.id">
            件名:
            <Link class="text-blue-400" :href="route('inertia.show', { id: blog.id })"> {{ blog.title }}</Link>,
            本文: {{ blog.content }}
        </li>
    </ul>
</template>
```

## Inertiajsのイベントコールバック

- onBefore : リクエスト直前
- onStart : リクエスト開始時
- onProgress : リクエスト進行中
- onSuccess : リクエスト成功時
- onError : エラー時
- onCancel : キャンセル時
- onFinish : リクエスト完了時

```php
//route
Route::delete('/inertia/{id}', [InertiaTestController::class, 'delete'])
    ->name('inertia.delete');
```

```php
//controller
<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\InertisaTest;
use App\Http\Requests\InertiaTestStoreRequest;

class InertiaTestController extends Controller {
    public function delete($id) {
        $book = InertisaTest::findOrfail($id);
        $book->delete();

        return to_route('inertia.index')
            ->with([
                'message' => '削除しました。'
            ]);
    }
}
```

```vue
<script setup>
import { Inertia } from '@inertiajs/inertia';

defineProps({
    id: String,
    blog: Object
})

const deleteConfirm = (id) => {
    Inertia.delete(`/inertia/${id}`, {
        onBefore: () => confirm('本当に削除しますか?')
    })
}

</script>

<template>
    {{ id }}<br>
    {{ blog.title }}<br>
    <button @click="deleteConfirm(blog.id)">削除</button>
</template>
```

## Vue.jsでスロットを使う

v-slotで名前付きスロットを使う  
v-slotを省略する場合は#

```vue
<!-- SlotTest -->
<script setup>
</script>

<template>
    <h1 class="font-bold text-xl text-gray-800">スロットテスト</h1>
    <!-- デフォルトスロット -->
    <slot />
    <div class="text-xl">
        <!-- 名前付きスロット -->
        <slot name="title" />
    </div>
    <slot name="content" />
</template>
```

```vue
<!-- SlotTestを利用する -->
<script setup>
import SlotTest from '@/Layouts/SlotTest.vue';
</script>

<template>
    <SlotTest>
        <!-- デフォルトスロットを使用する -->
        <template #default>
            デフォルトスロット
        </template>
        <!-- 名前付きスロットを使用する -->
        <template #title>
            <div class="bg-blue-400">タイトル</div>
        </template>
        <template #content>
            <div class="bg-green-400">
                <ul>
                    <li>コンテンツ1</li>
                    <li>コンテンツ2</li>
                    <li>コンテンツ3</li>
                </ul>
            </div>
        </template>
    </SlotTest>
</template>
```

## definePropsとdefineEmits
親から子へ値を渡す時はdefineProps  
子から親へ値を渡す時はdefineEmits  

```vue
<!-- TextInput.vue -->
<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

<template>
    <input class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input">
</template>

```

```vue
<script setup>
import TextInput from '@/Components/TextInput.vue';

const emitTest = (e) => {
    console.log(e);
};

</script>

<template>
    <div class="container mx-auto">
        <div class="h-full w-full flex justify-center items-center">
            <!-- 
                modelValueにセットした値がTextInputに渡る。
                @(v-on)でinputのvalueが書き換わる度にupdate:modelValueで値が親に渡りemitTestメソッドが走る
             -->
            <TextInput modelValue="初期値が入ります" @update:modelValue="emitTest"></TextInput>
        </div>
    </div>
</template>
```
