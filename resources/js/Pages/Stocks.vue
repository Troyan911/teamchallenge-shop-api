<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router} from "@inertiajs/vue3";
import {ref} from "vue";

defineProps({
    Stocks: Object
})

const data = ref({
    newQuantity: null,
});

const displayModal = ref('none')
const newQuantity = ref(null)
const idToChange = ref(null)

const ChangeQuantity = function () {
    router.put(`stocks/${idToChange.value}`, {newQt: newQuantity.value})
    displayModal.value = 'none'
    newQuantity.value = null
    idToChange.value = null
}

const DeleteTypeOfProduct = function (stockToDelete) {
    router.delete(`stocks/${stockToDelete}`)
}

</script>

<template>
    <Head title="Stocks"/>

    <AuthenticatedLayout>

        <div v-if="Object.keys($props.Stocks).length===0" class="flex items-start mt-20 h-full" >
            <h1>
                <b>
                    Nothing to show, add products
                </b>
            </h1>
        </div>


        <div v-else class="flex justify-center flex-col w-full">
            <div class="flex flex-col items-center mt-10 mb-10">
                <h1>LIST ALL STOCKS</h1>
            </div>
            <table class="border-collapse border mr-6 ml-6 border-slate-400">
                <thead class="sticky top-28 bg-amber-600">
                <tr>
                    <th class="border border-slate-300 max-w-24">Name</th>
                    <th class="border border-slate-300 max-w-24">Size</th>
                    <th class="border border-slate-300 max-w-24">Color</th>
                    <th class="border border-slate-300 max-w-24">Quantity</th>
                    <th class="border border-slate-300 max-w-24">Delete item</th>
                </tr>
                </thead>
                <tbody v-for="stock in $props.Stocks"
                       :key="stock.idOfTypeOfProduct">
                <tr>
                    <td class="border border-slate-300 text-center pt-2 pb-2">
                        {{ stock.nameOfProduct }}
                    </td>
                    <td class="border border-slate-300 text-center pt-2 pb-2">
                        {{ stock.size }}
                    </td>
                    <td class="border border-slate-300 text-center pt-2 pb-2">
                        <div class="flex flex-col items-center">
                            {{ stock.color }}
                            <div class="w-12 h-12 bg-red-400 rounded-full" :style="{'background-color': stock.hexOfColor}"></div>
                        </div>

                    </td>
                    <td class="border border-slate-300 text-center pt-2 pb-2">
                        {{ stock.quantity }}
                        <div>
                            <button id="myBtn" @click.prevent="displayModal='block'; idToChange=stock.idOfTypeOfProduct"
                            class="bg-orange-500 rounded-full w-36"
                            >
                                Change Qty.
                            </button>
                            <div id="myModal" class="modal"
                                 :style="{ display: displayModal }"
                            >
                                <div class="modal-content">
                                <span class="close"
                                      @click.prevent="displayModal='none'; newQuantity=null ">&times;</span>
                                    <form @submit.prevent="ChangeQuantity">
                                        <p>Change quantity</p>
                                        <input type="number"
                                               v-model="newQuantity"
                                               class="max-w-28"
                                        >
                                        <button type="submit" class="ml-5 bg-orange-500 rounded-full w-20"
                                                :disabled="newQuantity<=0"
                                        >New Qty.</button>
                                        <p v-show="newQuantity<0" class="text-red-400">Quantity couldn't be less than zero. </p>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </td>
                    <td class="border border-slate-300 text-center pt-2 pb-2">
                        <button @click="DeleteTypeOfProduct(stock.idOfTypeOfProduct)">delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>

</template>

<style scoped>
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0, 0, 0); /* Fallback color */
    background-color: rgba(0, 0, 0, 0.1); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 25%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
