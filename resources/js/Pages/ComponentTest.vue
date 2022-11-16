<script setup>
import TextInput from '@/Components/TextInput.vue';

const emitTest = (e) => {
    console.log(e);
};

</script>

<template>
    <div class="container mx-auto">
        <div class="h-full w-full flex justify-center items-center">
            <TextInput modelValue="初期値が入ります" @update:modelValue="emitTest"></TextInput>
        </div>
    </div>
</template>
