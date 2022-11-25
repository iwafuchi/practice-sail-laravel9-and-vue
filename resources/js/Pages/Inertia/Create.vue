<script setup>
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import InputError from '@/Components/InputError.vue';

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
        <InputError :message="errors.title"></InputError>
        <input type="text" name="content" v-model="form.content"><br>
        <InputError :message="errors.content"></InputError>
        <button>送信</button>
    </form>
</template>
