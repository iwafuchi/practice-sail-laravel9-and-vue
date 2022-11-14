<script setup>
import SlotTest from '@/Layouts/SlotTest.vue';
</script>

<template>
    <SlotTest>
        <template #default>
            デフォルトスロット
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
