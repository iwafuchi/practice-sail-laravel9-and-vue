<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

type Props = {
    tweets: any
}

defineProps<Props>();

const emit = defineEmits(['delete-tweet']);
const deleteTweet = (id: number) => {
    emit('delete-tweet', id);
}

</script>
<template>
    <li v-for="tweet in tweets" :key="tweet?.id" class="tweet-list">
        <span>{{ tweet?.description }}</span>
        <button @click="deleteTweet(tweet?.id)" class="delete-button">delete</button>
    </li>
</template>
<style scoped>
.delete-button {
    background-color: orangered;
    color: white;
    padding: 5px 18px;
}

.tweet-list {
    display: flex;
    justify-content: space-between;
    list-style: none;
    width: 600px;
    height: 40px;
    margin-bottom: 10px;
    text-align: left;
    padding: 5px;
    background-color: aquamarine;
}
</style>
