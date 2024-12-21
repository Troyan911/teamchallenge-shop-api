<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {ref} from "vue";

defineProps({
    ProductCard: Object,
    ColorsAndImages: Object
    }
)

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
                <p>PRODUCTS: {{ $props.ProductCard.title}}</p>
                <p>Slug: {{ $props.ProductCard.slug}}</p>
                <p>Gender: {{ $props.ProductCard.gender}}</p>
                <p>Description: {{ $props.ProductCard.description}}</p>
                <p>Old price: {{ $props.ProductCard.price}}</p>
                <p>New price: {{ $props.ProductCard.new_price}}</p>
                <div class="flex flex-row justify-between w-48">

                    <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            @click.prevent="DeleteProduct(route('product.destroy',`${$props.ProductCard.id}`))"
                    >
                        DELETE
                    </button>

                    <button type="submit"

                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Edit
                    </button>
                </div>
                <div
                    class="flex flex-row justify-center flex-wrap"
                >
                    <div v-for="item in ColorsAndImages">
                        <div class="flex flex-col items-center ml-5 w-80 h-full">
                            <p>Color: {{item.color}}</p>
                            <div class="w-12 h-12 bg-red-400 rounded-full" :style="{'background-color': item.hexOfColor}"></div>
                            <img :src="`${item.path}`" class="rounded-lg object-cover h-full ">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
