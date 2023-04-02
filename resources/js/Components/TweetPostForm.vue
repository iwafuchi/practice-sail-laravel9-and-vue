<script setup lang="ts">
import { ref, defineEmits } from 'vue';

const inputtingDescripttion = ref<string>('');

const emit = defineEmits(['post-tweet']);
const postTweet = () => {
    emit('post-tweet', inputtingDescripttion.value);
    inputtingDescripttion.value = '';
}

</script>
<template>
    <div class="form-container">
        <input v-model="inputtingDescripttion">
        <button @click="postTweet" style="margin-top: 1rem;" class="save-button">post</button>
    </div>
</template>
<style scoped>
.form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: aliceblue;
    padding: 24px 0;
    width: 60%;
    margin-bottom: 12px;
    border-radius: 4px;
}

.save-button {
    background-color: aquamarine;
    color: white;
    padding: 5px 18px;
}
</style>
