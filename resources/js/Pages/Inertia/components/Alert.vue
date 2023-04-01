<template>
    <button @click="displayAlert()">アラート表示</button>
</template>

<script lang="ts">
import { defineComponent, defineProps } from "vue";

interface Props {
    message: string;
}
const props = defineProps<Props>();

export default defineComponent({
    setup() {
        const displayAlert = () => {
            alert(props.message);
        };

        return {
            displayAlert,
        };
    },
});
</script>
