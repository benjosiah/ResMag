<template>
    <div class="fixed top-0 right-0 mr-10 mb-10 mt-3 bg-white " v-if="open">
        <div class="shadow-md rounded p-4 relative">
            <div class="absolute top-auto right-2 bottom-auto" >
                <span @click="$emit('close')">
                    <i class="text-sm text-center text-black font-light fa fa-times cursor-pointer"></i>
                </span>
            </div>
            <div class="px-3">
                <p class="text-gray-900">Are you sure you want to delete this resource?</p>
                <div class="flex justify-between mt-5">
                    <div class="flex justify-between items-center">
                        <span @click="$emit('delete')" class="text-gray-900 px-5 py-2 bg-blue-500 hover:bg-blue-700 cursor-pointer">
                            <i class="text-sm text-center text-white font-light fa fa-check cursor-pointer rounded"></i>
                        </span>
                        <span @click="$emit('close')" class="text-gray-900 ml-2 px-5 py-2  bg-red-500 hover:bg-red-700 cursor-pointer">
                            <i class="text-sm text-center text-white font-light fa fa-times cursor-pointer"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            message:{
                type: String,   
            },
            open:{
                type: Boolean,
                default: false
            },
        },


    }
</script>
