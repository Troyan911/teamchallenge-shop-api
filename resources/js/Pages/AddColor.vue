<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import { ref} from "vue";

const data = ref({
    colorName: '',
    hexCode: '',
});


function sendData() {
    console.log(data.value)
   router.post('/saveColor', data.value)

    data.value.colorName = ''
    data.value.hexCode = ''

}

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-center flex-col w-96">

            <div class="flex flex-col items-center mt-10 mb-10">
                <h1>Add possible color of product.</h1>
            </div>

            <form @submit.prevent="sendData()">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Name of color</label>
                        <input type="text" id="last_name"
                               v-model="data.colorName"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required/>
                    </div>
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hex code</label>
                        <input type="text" id="last_name"
                               placeholder="#ff0000"
                               v-model="data.hexCode"
                               class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required/>
                    </div>

                </div>
                <p>How color look like on site:</p>
                <div :style="{backgroundColor: data.hexCode}"
                class="w-full h-7"
                ></div>
                <div class=" flex flex-row justify-center mt-5  w-full">
                    <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Submit
                    </button>
                </div>

            </form>
        </div>
    </AuthenticatedLayout>
</template>
