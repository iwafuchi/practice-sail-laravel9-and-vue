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
        return to_route('inertia.index')
            ->with([
                'message' => '登録しました。'
            ]);
    }
}
