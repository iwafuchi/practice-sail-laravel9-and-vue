<script setup lang="ts">
import { ref, Ref } from 'vue';
import PersonList from './PersonList.vue';
import PersonPostForm from './PersonPostForm.vue';

export type Person = {
    id: number,
    name: string,
    age: number
}

const persons: Ref<Person[]> = ref([
    {
        id: 0,
        name: 'John',
        age: 24,
    },
    {
        id: 1,
        name: 'Mike',
        age: 27,
    }
]);

const registerPerson = (person: Person) => {
    persons.value.push(person);
}

const deletePerson = (id: number) => {
    persons.value = persons.value.filter(person => person.id !== id);
}

</script>

<template>
    <div class="container">
        <h1 class="text-3xl">Title</h1>
        <PersonPostForm @register="registerPerson"></PersonPostForm>
        <div class="list-container">
            <ul>
                <PersonList :persons="persons" @delete="deletePerson"></PersonList>
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
