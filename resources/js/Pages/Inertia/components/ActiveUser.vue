<script setup>
import { reactive } from 'vue';

const user = reactive({
    firstName: "aaa",
    lastName: "bbb",
})
</script>

<template>
    <div>{{ user.firstName }}</div>
    <div>{{ user.lastName }}</div>
</template>
