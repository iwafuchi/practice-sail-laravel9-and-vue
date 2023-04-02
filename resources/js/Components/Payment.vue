<script setup lang="ts">
import { ref, reactive, computed, watch, toRefs, onBeforeMount, onMounted, onUpdated } from "vue";
const itemName1 = ref<string>("Desk");
const itemName2: string = "Bike";

const price1: number = 40000;
const price2: number = 20000;

const item1 = reactive({
    name: "Desk",
    price: 40000,
});

const url1: string = "https://www.amazon.co.jp/";
const url2: string = "https://www.rakuten.co.jp/";

const buy = (itemName: string): void => {
    alert(`Are you sere to buy ${itemName} ?`);
}

const clear = () => {
    item1.name = "";
    item1.price = 0;
}

const budget = 50000;

// const priceLabel = computed(() => {
//     if (item1.price > budget * 2) {
//         return 'tooooooo expensive...';
//     } else if (item1.price > budget) {
//         return 'too expensive...';
//     } else {
//         return item1.price + '￥';
//     }
// });

onBeforeMount(() => {
    console.log('before mount');
})

onMounted(() => {
    console.log('mounted');
})

onUpdated(() => {
    console.log('update');
})

const priceLabel = ref<string>(item1.price + "￥");
const { price } = toRefs(item1)
watch(price, () => {
    if (price.value > budget * 2) {
        priceLabel.value = 'tooooooo expensive...';
    } else if (price.value > budget) {
        priceLabel.value = 'too expensive...';
    } else {
        priceLabel.value = price.value + '￥';
    }
})
</script>

<template>
    <div class="container">
        <h1>Payment</h1>
        <input v-model="item1.name" class="border-2 border-gray-100" />
        <input v-model="item1.price" class="border-2 border-gray-100" />
        <button @click="clear" class="border-2">clear</button>
        <div class="payment">
            <label>{{ item1.name }}</label>
            <label>{{ priceLabel }}</label>
            <a v-bind:href="url1">bought at ...</a>
            <button type="button" @click="buy(item1.name)">BUY</button>
        </div>
        <div class="payment">
            <label>{{ itemName2 }}</label>
            <label>{{ price2 }}</label>
            <a v-bind:href="url2">bought at ...</a>
            <button type="button" @click="buy(itemName2)">BUY</button>
        </div>
    </div>
</template>

<style scoped>
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.payment {
    display: flex;
    justify-content: space-between;
    width: 400px;
    height: 80px;
    background-color: azure;
    margin-bottom: 5px;
}

input {
    margin-bottom: 8px;
}

label {
    font-size: 20px;
}
</style>
