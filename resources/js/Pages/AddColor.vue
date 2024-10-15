<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {ref, watch} from "vue";

defineProps({
    listAllColors: Object
});

const data = ref({
    colorName: '',
    hexCode: '',
});

watch(data.value,()=>{
    data.value.hexCode=data.value.hexCode.replace(' ','')
})

function sendData() {
    router.get('/color/create ', data.value)
    data.value.colorName = ''
    data.value.hexCode = ''
}

function deleteColor(itemDelete) {
    router.delete(`color/${itemDelete}`)
}

</script>

<template>
    <Head title="Add color"/>
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
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hex
                            code</label>
                        <input type="text" id="last_name"
                               placeholder="#ff0000"
                               v-model="data.hexCode"
                               class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required/>
                    </div>

                </div>
                <div v-if="data.hexCode.length===7">
                    <p>How color look like on site:</p>
                    <div :style="{backgroundColor: data.hexCode}"
                         class="w-full h-7"
                    ></div>
                </div>
                <div v-if="data.hexCode.length!==7">
                    <p>HEX code has to have 7 characters, example #ff0000</p>
                </div>

                <div class=" flex flex-row justify-center mt-5  w-full">
                    <button type="submit"
                            :disabled="data.hexCode.length!==7"
                            :class="data.hexCode.length===7 ? 'bg-blue-700' : 'bg-gray-600'"
                            class="text-white  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Submit
                    </button>
                </div>

                <div class="flex flex-row items-center ">
                    <table class="border-collapse border mr-6 ml-6 border-slate-400 mt-10 w-full">
                        <thead class="sticky top-28 bg-amber-600">
                        <tr>
                            <th class="border border-slate-300 max-w-24">Name</th>
                            <th class="border border-slate-300 max-w-24">Color</th>
                            <th class="border border-slate-300 max-w-24">Hex code</th>
                            <th class="border border-slate-300 max-w-24">Delete</th>
                        </tr>
                        </thead>
                        <tbody
                            v-for="color in listAllColors"
                        >
                        <tr>
                            <td class="border border-slate-300 text-center pt-2 pb-2">
                                {{color.color}}
                            </td>
                            <td class="border border-slate-300 text-center pt-2 pb-2 flex flex-row justify-center">
                                <div class="w-8 h-8 bg-red-400 rounded-full" :style="{'background-color': color.hex_code}"></div>
                            </td>
                            <td class="border border-slate-300 text-center pt-2 pb-2">
                                {{color.hex_code}}
                            </td>
                            <td class="border border-slate-300 text-center pt-2 pb-2">
                                <button @click.prevent="deleteColor(color.color_id)">Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>



            </form>
        </div>
    </AuthenticatedLayout>
</template>
