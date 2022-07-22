<template>
    <div class="fixed top-0 right-0 mr-10 mb-10 mt-3 " v-if="open" :class="(type=='error')?'bg-red-500':'bg-green-500'">
        <div class="shadow-md rounded p-4 relative">
            <div class="absolute top-auto right-2 bottom-auto" >
                <span>
                    <i class="text-sm text-center text-white font-light fa fa-times cursor-pointer"></i>
                </span>
            </div>
            <div class="px-3">
                <p class="text-gray-50">{{message}}</p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            type:{
                type: String,   
            },
            message:{
                type: String
            },
            open:{
                type: Boolean,
                default: false
            },
           
        },

        

    }
</script>
