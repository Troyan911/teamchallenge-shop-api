<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {ref} from "vue";

defineProps(['ProductCard'])



function DeleteProduct(x) {
    console.log(x)

    router.delete(`${x}`)
}


</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-center flex-col w-full">

            <div class="flex flex-col items-center mt-10 mb-10">
                <h1>PRODUCTS CARD</h1>
                <p>Title: {{ $props.ProductCard.title }}</p>
                <p>SKU: {{ $props.ProductCard.SKU }}</p>
                <p>ID: {{ $props.ProductCard.id }}</p>
                <div class="flex flex-row justify-between w-48">

<!--                    <button type="submit"-->
<!--                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"-->
<!--                            @click.prevent="DeleteProduct(route('product.destroy',`${$props.ProductCard.id}`))"-->
<!--                    >-->
<!--                        DELETE-->
<!--                    </button>-->

                    <button type="submit"

                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Edit
                    </button>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
