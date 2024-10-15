<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import { ref} from "vue";
defineProps(['listOfProducts'])
</script>

<template>
    <Head title="Product list"/>

    <AuthenticatedLayout>
        <div class="flex justify-center flex-col w-full">
            <div class="flex flex-col items-center mt-10 mb-10">
                <h1>LIST ALL PRODUCTS</h1>
            </div>
            <table class="border-collapse border mr-6 ml-6 border-slate-400">
                <thead class="sticky top-28 bg-amber-600">
                <tr>
                    <th class="border border-slate-300 max-w-24">Index</th>
                    <th class="border border-slate-300 max-w-24">Product Name</th>
                    <th class="border border-slate-300 max-w-24">Size</th>
                    <th class="border border-slate-300 max-w-28">SKU</th>
                    <th class="border border-slate-300 max-w-24">Color</th>

                </tr>
                </thead>
                <tbody v-for="(product,index) in $props.listOfProducts">
                <tr>
                    <td class="border border-slate-300 text-center pt-2 pb-2"><Link
                        :href="route('product.show',`${product.id}`)"
                    >{{index+1}}</Link> </td>
                    <td class="border border-slate-300 text-center pt-2 pb-2"><Link
                        :href="route('product.show',`${product.id}`)"
                    >{{product.title}}</Link> </td>
                    <td class="border border-slate-300 text-center pt-2 pb-2"><Link
                        :href="route('product.show',`${product.id}`)"
                    >{{product.size}}</Link> </td>
                    <td class="border border-slate-300 text-center pt-2 pb-2"><Link
                        :href="route('product.show',`${product.id}`)"
                    >{{product.SKU}}</Link> </td>
                    <td class="border border-slate-300 text-center pt-2 pb-2"><Link
                        :href="route('product.show',`${product.id}`)"
                    >{{product.color}}</Link> </td>
                </tr>

                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
