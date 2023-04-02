<script setup lang="ts">
import { ref } from 'vue';
import TweetPostForm from '@/Components/TweetPostForm.vue';
import TweetList from '@/Components/TweetList.vue';

const tweets:any= ref([
    {
        id: 0,
        description: "Hello World !"
    },
    {
        id: 1,
        description: "Hello World !"
    },
    {
        id: 2,
        description: "Hello World !"
    }
]);

const postTweet = (description: string) =>{
    if(description.length === 0){
        alert('Please enter text');
        return;
    };
    const tweet = {
        id: Math.random(),
        description: description
    };
    tweets.value.push(tweet);
}

const deleteTweet = (id:number) => {
    tweets.value = tweets.value.filter(t => t.id !== id);
}

</script>

<template>
    <div class="container">
        <h1 class="text-3xl">Tweeter</h1>
        <TweetPostForm @post-tweet="postTweet"></TweetPostForm>
        <div class="tweet-container">
            <p v-if="tweets.length <= 0">No tweets have been added</p>
            <ul>
                <TweetList :tweets="tweets" @delete-tweet="deleteTweet"></TweetList>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
}
</style>
