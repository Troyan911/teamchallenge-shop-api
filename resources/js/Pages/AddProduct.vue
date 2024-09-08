<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {computed, ref} from "vue";


defineProps({
        size: Array,
        gender: Array,
        color: Array
    }
)

const data = ref({
    slug: '',
    directory: '',
    title: '',
    description: '',
    SKU: '',
    gender: '',
    price: null,
    newPrice: null,
    size: '',
    color: '',
    photo: null
});

const SKU = function (product) {

    // Helper function to get the first letter of each word in the slug
    function getFirstLettersFromSlug(slug) {
        return slug
            .split(' ')  // Split the slug by hyphens (assuming slugs use hyphens between words)
            .map(word => word.charAt(0).toUpperCase())  // Get the first letter of each word
            .join('');  // Join the letters back together
    }

    // Always use the slug to generate the code
    const slugCode = getFirstLettersFromSlug(product.slug);

    // Gender code: M for male, F for female, U for unisex
    let genderCode = '';
    if (product.gender === 'male') {
        genderCode = 'M';
    } else if (product.gender === 'female') {
        genderCode = 'F';
    } else if (product.gender === 'unisex') {
        genderCode = 'U';
    }

    // Color code: take the first three letters of the color and convert to uppercase
    const colorCode = product.color ? product.color.substring(0, 3).toUpperCase() : '';

    // Size code: take the size as is
    const sizeCode = product.size.toUpperCase();

    // Combine the parts to form the SKU
    const SKU = `${slugCode}-${genderCode}-${colorCode}-${sizeCode}`;
    data.value.SKU = SKU
    data.value.directory = SKU
    return SKU;
}


function sendData() {
    console.log(data.value)
    router.post('/save', data.value)

    data.value.slug = ''
    data.value.directory = ''
    data.value.title = ''
    data.value.description = ''
    data.value.SKU = ''
    data.value.gender = ''
    data.value.price = null
    data.value.newPrice = null
    data.value.size = ''
    data.value.color = ''
    data.value.photo = null
}

//Directory equal SKU
//make unique SKU
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-center flex-col w-96">

            <div class="flex flex-col items-center mt-10 mb-10">
                <h1>Add new product.</h1>
                <p class="mt-5 mb-5">SKU of product: {{ SKU(data) }}</p>
            </div>

            <form @submit.prevent="sendData()">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Name of product</label>
                        <input type="text" id="last_name"
                               v-model="data.title"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required/>
                    </div>

                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Design
                            Slug (name in url)</label>
                        <input type="text" id="last_name"
                               placeholder="T-shirt-classic"
                               v-model="data.slug"
                               class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               required/>
                    </div>

                    <div class="max-w-sm mx-auto"
                         style="width: 100%"
                    >
                        <label for="countries"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Size</label>
                        <select id="countries"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                v-model="data.size"
                                required
                        >
                            <option value="">Choose</option>
                            <option v-for="x in size" :value="x">{{ x }}</option>
                        </select>
                    </div>

                    <div class="max-w-sm mx-auto"
                         style="width: 100%"
                    >
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                        <select id="countries"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                v-model="data.gender"
                                required
                        >
                            <option value="">Choose</option>
                            <option v-for="x in gender" :value="x">{{ x }}</option>
                        </select>
                    </div>


                    <div class="max-w-sm mx-auto"
                         style="width: 100%"
                    >
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Color</label>
                        <select id="countries"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                v-model="data.color"
                                required
                        >
                            <option value="">Choose</option>
                            <option v-for="x in color" :value="x">{{ x }}</option>
                        </select>
                    </div>


                    <div>
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Price</label>
                        <input type="number" id="first_name"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               v-model="data.price"
                               required/>
                    </div>

                    <div>
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            New Price</label>
                        <input type="number" id="first_name"
                               v-model="data.newPrice"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>

                </div>

                <div class="mt-5 mb-5">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Description</label>
                    <textarea type="text" id="last_name"
                              rows="6"
                              v-model="data.description"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              required/>
                </div>

                <form enctype="multipart/form-data">
                    <div class="mb-3 flex flex-row">
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Add photo</label>
                        <input type="file" id="first_name" @input="data.photo = $event.target.files" multiple/>
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
