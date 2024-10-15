<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard"/>
    <AuthenticatedLayout>
        <div class="flex justify-center items-start" style="width: 100%">
            <div class="grid grid-cols-3 w-full ml-10 mr-10">
                <Link
                    :href="route('product.create')"
                    class="text-gray-500-500  mr-5 hover:text-gray-400 border-2 border-gray-500 text-center m-4 h-40"
                >
                    <div class="flex justify-center items-center" style="height: 100%">
                        <p>Add Product</p>
                    </div>
                </Link>
                <Link
                    :href="route('stocks.index')"
                    class="text-gray-500-500  mr-5 hover:text-gray-400 border-2 border-gray-500 text-center m-4 h-40"
                >
                    <div class="flex justify-center items-center" style="height: 100%">
                        <p>Stocks</p>
                    </div>
                </Link>
                <Link
                    :href="route('product.index')"
                    class="text-gray-500-500  mr-5 hover:text-gray-400 border-2 border-gray-500 text-center m-4 h-40"
                >
                    <div class="flex justify-center items-center" style="height: 100%">
                        <p>Product List</p>
                    </div>
                </Link>
                <Link
                    :href="route('color.index')"
                    class="text-gray-500-500  mr-5 hover:text-gray-400 border-2 border-gray-500 text-center m-4 h-40"
                >
                    <div class="flex justify-center items-center" style="height: 100%">
                        <p>Add possible color of clothes</p>
                    </div>
                </Link>
            </div>

            <img :src="`/storage/`">

        </div>

    </AuthenticatedLayout>
</template>
