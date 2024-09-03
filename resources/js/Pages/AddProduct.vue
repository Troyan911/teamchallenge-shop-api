<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
defineProps({
    size: Array,
    gender: Array,
    color: Array
    }
)

//Directory equal SKU
//make unique SKU
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout >
<div class="flex justify-center flex-col w-96">
    <p class="text-end">SKU of product: TEST</p>
    <div class="flex justify-center mt-10 mb-10">
        <h1>Add new product.</h1>
    </div>

    <form>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Name of product</label>
                <input type="text" id="last_name"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       required/>
            </div>

            <div>
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Design
                    Slug (short-name)</label>
                <input type="text" id="last_name"
                       placeholder="T-shirt-classic"
                       class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       required/>
            </div>

            <div>
                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Description</label>
                <input type="text" id="last_name"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       required/>
            </div>

            <form class="max-w-sm mx-auto"
            style="width: 100%"
            >
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Size</label>
                <select id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"

                >
                    <option >Choose</option>
                    <option v-for="x in size" :value="x">{{x}}</option>
                </select>
            </form>

            <form class="max-w-sm mx-auto"
                  style="width: 100%"
            >
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                <select id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"

                >
                    <option >Choose</option>
                    <option v-for="x in gender" :value="x">{{x}}</option>
                </select>
            </form>

            <form class="max-w-sm mx-auto"
                  style="width: 100%"
            >
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Color</label>
                <select id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"

                >
                    <option >Choose</option>
                    <option v-for="x in color" :value="x">{{x}}</option>
                </select>
            </form>



            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Price</label>
                <input  type="number" id="first_name"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       required/>
            </div>

            <div>
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    New Price</label>
                <input  type="number" id="first_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required/>
            </div>

        </div>

        <form enctype="multipart/form-data">
            <div class="mb-3 flex flex-row">
                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Add photo</label>
                <input type="file" id="first_name" multiple/>
            </div>
        </form>

        <div class=" flex flex-row justify-center  w-full">
            <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Submit
            </button>
        </div>

    </form>
</div>
    </AuthenticatedLayout>
</template>
