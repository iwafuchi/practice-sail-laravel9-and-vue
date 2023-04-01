<template>
    <div class="flex justify-center flex-col">
        <Alert></Alert>
        <Alert message="aaa"></Alert>
        <HelloWorld msg="Hello" />
    </div>
</template>

<script setup lang="ts">
import Alert from './components/Alert.vue';
import HelloWorld from './components/HelloWorld.vue';
</script>
