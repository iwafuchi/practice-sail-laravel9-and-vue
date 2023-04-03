<script setup lang="ts">
import { reactive } from 'vue';

const person = reactive({
    id: 0,
    name: '',
    age: 0
});


const emit = defineEmits(['register']);

const register = () => {
    person.id = Math.random();
    emit('register', { ...person });
}


</script>

<template>
    <div class="form-container">
        <div class="input-container">
            <div class="input-column">
                <span>name:</span>
                <input class="input" v-model="person.name">
            </div>
            <div class="input-column">
                <span>age:</span>
                <input class="input" type="number" v-model="person.age">
            </div>
            <button @click="register" class="register-button">register</button>
        </div>
    </div>
</template>

<style scoped>
input {
    margin-bottom: 16px;
    width: 200px;
}

span {
    font-size: 20px;
    font-weight: bold;
}

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

.input-column {
    width: 280px;
    display: flex;
    justify-content: space-between;
}

.input-container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 40%;
    margin-bottom: 20px;
}
</style>
