<script setup>
</script>

<template>
    <h1 class="font-bold text-xl text-gray-800">スロットテスト</h1>
    <slot />
    <div class="text-xl">
        <slot name="title" />
    </div>
    <slot name="content" />
</template>
