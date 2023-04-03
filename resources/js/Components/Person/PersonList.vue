<script setup lang="ts">
import { defineEmits } from 'vue';
type Props = {
    persons: any
}
defineProps<Props>();
const emit = defineEmits(['delete']);
const deletePerson = (id: number) => {
    emit('delete', id);
}
</script>

<template>
    <li v-for="person in persons" :key="person.id" class="person-list">
        <span>{{ person.name }}</span>
        <span>age:{{ person.age }}</span>
        <button @click="deletePerson(person.id)">delete</button>
    </li>
</template>

<style scoped>
.person-list {
    display: flex;
    justify-content: space-between;
    list-style: none;
    text-align: left;
    width: 300px;
    height: 40px;
    margin-bottom: 12px;
    border-radius: 4px;
    font-size: 20px;
    background-color: rgb(21, 114, 196);
}
</style>
