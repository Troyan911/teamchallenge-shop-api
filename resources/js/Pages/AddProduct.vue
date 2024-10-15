<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import {computed, ref, watch} from "vue";
import { usePage } from "@inertiajs/vue3";

defineProps({
        size: Object,
        gender: Array,
        color: Object,
        message: String
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
    productsVariants: [],
    photo: []
});

const checkedColor = ref([])
const checkedSize = ref([])
const title = ref('')
const slug = ref('')

watch(title, () => {
    data.value.title = title.value
    router.post('/checkUniquenessOfTitleAndSlug', {title: data.value.title, slug: data.value.slug })
   })

watch(slug, () => {
    data.value.slug = slug.value
    router.post('/checkUniquenessOfTitleAndSlug', {title: data.value.title, slug: data.value.slug })
})

watch(data.value, () => {
    data.value.slug = data.value.slug.replace(/\s{1,10}/g, '-').toLowerCase()
})

watch(checkedSize, () => {
    data.value.productsVariants = checkedSize.value.map(item => item.split('-'))
})

watch(data.value, () => {

        // Helper function to get the first letter of each word in the slug
        function getFirstLettersFromSlug(slug) {
            return slug
                .split('-')  // Split the slug by hyphens (assuming slugs use hyphens between words)
                .map(word => word.charAt(0).toUpperCase())  // Get the first letter of each word
                .join('');  // Join the letters back together
        }

        // Always use the slug to generate the code
        const slugCode = getFirstLettersFromSlug(data.value.slug);

        // Gender code: M for male, F for female, U for unisex
        let genderCode = '';
        if (data.value.gender === 'male') {
            genderCode = 'M';
        } else if (data.value.gender === 'female') {
            genderCode = 'F';
        } else if (data.value.gender === 'unisex') {
            genderCode = 'U';
        }

        // Combine the parts to form the SKU
        const SKU = `${slugCode}-${genderCode}`;
        data.value.SKU = SKU
        data.value.directory = SKU
    }
)
const takePhoto = function (color, storage) {
    let photo = {
        color: color,
        photo: storage
    }
    data.value.photo.push(photo)
    console.log(color)
    console.log(storage)
}

function sendData(route) {

    router.post(`${route}`, data.value)

    data.value.slug = ''
    data.value.directory = ''
    data.value.title = ''
    data.value.description = ''
    data.value.SKU = ''
    data.value.gender = ''
    data.value.price = null
    data.value.newPrice = null
    data.value.productsVariants = []
    data.value.photo = null
}

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="flex justify-between flex-col">
            <div class="flex flex-col items-center mt-10 mb-10">
            </div>
            <div v-if="!$page.props.flash.message">
                <h1 class="text-center mb-5">Add new product.</h1>
                <form @submit.prevent="sendData(route('product.store'))">

                    <div class="flex flex-row">
                        <div class="mr-10">
                            <div>
                                <label for="last_name"
                                       class="block mb-2 text-sm font-medium text-red-500 dark:text-white">
                                    <b>Name of product</b></label>
                                <p>The name has to be unique from previous one</p>
                                <input type="text" id="last_name"
                                       v-model="title"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required/>
                                <p v-if="$page.props.uniquenessOfTitleAndSlug.messageUnique==='Both has been taken.' || $page.props.uniquenessOfTitleAndSlug.messageUnique==='Title has been taken.'"
                                   class="text-red-400"
                                >
                                    This title has been already taken.
                                </p>
                            </div>
                            <div class="mt-5 mb-5">
                                <div class="flex flex-row">
                                    <label for="last_name"
                                           class="block mb-2 text-sm font-medium text-red-500 dark:text-white">Design
                                        Slug.</label>
                                    <div class="tooltip ml-2">
                                        <i style="font-size:15px; color: red" class="fa">&#xf059;</i>
                                        <div class="tooltiptext">
                                            <p> The Slug is short name which you will see as part of url.</p>
                                            <p>Example: http://siteName/<b>classic-T-shirt</b></p>
                                            <p>This name has to be unique from previous one</p>
                                            <p>Use only English words</p>
                                        </div>
                                    </div>
                                </div>


                                <input type="text" id="last_name"
                                       placeholder="classic-T-shirt"
                                       v-model="slug"
                                       class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       required/>
                                <p v-if="$page.props.uniquenessOfTitleAndSlug.messageUnique==='Both has been taken.' || $page.props.uniquenessOfTitleAndSlug.messageUnique==='Slug has been taken.'"
                                   class="text-red-400"
                                >
                                    This slug has been already taken.
                                </p>
                            </div>
                            <div class="mt-5 mb-5">
                                <label for="last_name"
                                       class="block mb-2 text-sm font-medium text-red-500 dark:text-white">
                                    Description</label>
                                <textarea type="text" id="last_name"
                                          rows="6"
                                          v-model="data.description"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                          required/>
                            </div>
                            <div class="max-w-sm mx-auto"
                                 style="width: 100%"
                            >
                                <label for="countries"
                                       class="block mb-2 text-sm font-medium text-red-500 dark:text-white">Gender</label>
                                <select id="countries"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        v-model="data.gender"
                                        required
                                >
                                    <option value="">Choose</option>
                                    <option v-for="x in gender" :value="x">{{ x }}</option>
                                </select>
                            </div>
                            <div>
                                <label for="first_name"
                                       class="block mb-2 text-sm font-medium text-red-500 dark:text-white">
                                    Old Price</label>
                                <input type="number" id="first_name"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       v-model="data.price"
                                       required/>
                            </div>
                            <div>
                                <label for="first_name"
                                       class="block mb-2 text-sm font-medium text-red-500 dark:text-white">
                                    New Price</label>
                                <input type="number" id="first_name"
                                       v-model="data.newPrice"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                />
                            </div>
                        </div>
                        <div class="min-w-96">
                            <div class="max-w-sm mx-auto"
                                 style="width: 100%"
                            >
                                <label for="countries"
                                       class="block mb-2 text-sm font-medium text-red-500 dark:text-white">Color</label>
                                <div>Checked size: {{ checkedSize }}</div>
                                <div class="flex flex-col ">
                                    <div v-for="(x,item) in color" :key="item">

                                        <input :value="x" :id="x" type="checkbox"
                                               class="mr-2"
                                               v-model="checkedColor"/>
                                        <label :for="x">{{ x }}</label>
                                        <div v-if="checkedColor.includes(x)">
                                            <form enctype="multipart/form-data">
                                                <div class="mb-3 flex flex-row">
                                                    <label for="first_name"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        Add photo</label>
                                                    <input type="file" id="first_name"
                                                           @input="takePhoto(item,$event.target.files)"
                                                           required
                                                    />
                                                </div>
                                            </form>
                                            <label for="x">Sizes for color: {{ x }} and quantity</label>
                                            <div class="flex flex-row">
                                                <div v-for="(size,index) in size" :key="index" class="mb-5">
                                                    <label :for="size">{{ size }}</label>
                                                    <input :value="item+'-'+index" :id="size" type="checkbox"
                                                           class="ml-1 mr-3"
                                                           v-model="checkedSize"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" flex flex-row justify-center  w-ful mt-5">
                        <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
            <div v-if="$page.props.flash.message"
                 class="flex flex-col items-center"
            >
                <p
                class="mb-5"
                >{{ $page.props.flash.message }}</p>
                <button
                >
                    <Link
                        :href="route('product.index')"
                    >
                        <div class="border-black bg-orange-500 w-20 rounded">
                            OK
                        </div>

                    </Link>
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.tooltip {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
}

.tooltip .tooltiptext{
    visibility: hidden;
    position: absolute;
    z-index: 1;
    width: 320px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>
