<script setup>
import SlotTest from '@/Layouts/SlotTest.vue';
</script>

<template>
    <SlotTest>
        <template #default>
            <div class="bg-red-400">デフォルトスロット</div>
        </template>
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
