<template>
    <div class="w-full mt-16">
        <div class="w-full bg-white shadow-md rounded p-10 relative">
            <!-- modal cancel -->
            <div class="absolute top-1 right-1 p-2 cursor-pointer" @click="$emit('close')">
                <span>
                    <i class="fa fa-times text-red-500"></i>
                </span>
            </div>
            <div class="w-full">
                <h3 class="font-semibold text-2xl">{{edit? "Edit" : "Add"}} Resource</h3>
            </div>
            <div class="w-full mt-10">
                <div class="w-full container">
                    <div class="w-full flex justify-between items-center">
                        <div class="w-1/2">
                            <label class="text-gray-800 font-semibold">Resource Title</label>
                        </div>
                        <div class="w-1/2">
                            <input type="text" class="w-full p-2 border border-gray-400 rounded" v-model="resource.title">
                             <span v-if="errors.title" class="text-red-500">{{ errors.title }}</span>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-10">
                    <div class="w-full flex justify-between items-center">
                        <div class="w-1/2">
                            <label class="text-gray-800 font-semibold">Resource Type</label>
                        </div>
                        <div class="w-1/2">
                            <select class="w-full p-2 border border-gray-400 rounded" v-model="resource.type" @change="changeType">
                                <option value="">Select Resource Type</option>
                                <option value="pdf">PDF</option>
                                <option value="html">HTML snipet</option>
                                <option value="url">URL</option>
                            </select>
                            <span v-if="errors.type" class="text-red-500">{{ errors.type }}</span>
                        </div>
                    </div>
                </div>
                <!-- upload pdf  -->
                <div class="w-full mt-10" v-if="resource.type == 'pdf'">
                    <div class="w-full flex justify-between items-center">
                        <div class="w-1/2">
                            <label class="text-gray-800 font-semibold">Upload PDF</label>
                        </div>
                        <div class="w-1/2">
                            <input type="file" class="w-full p-2 border border-gray-400 rounded" @input="resource.pdf = $event.target.files[0]">
                            <span v-if="errors.pdf" class="text-red-500">{{ errors.pdf }}</span>
                        </div>
                    </div>
                </div>
                <!-- description -->
                <div class="w-full mt-10">
                    <div class="w-full flex justify-between items-center">
                        <div class="w-1/2">
                            <label class="text-gray-800 font-semibold">Description</label>
                        </div>
                        <div class="w-1/2">
                            <textarea class="w-full p-2 border border-gray-400 rounded" v-model="resource.description"></textarea>
                            <span v-if="errors.description" class="text-red-500">{{ errors.description }}</span>
                        </div>
                    </div>
                </div>
                <!-- Html snipet -->
                <div class="w-full mt-10" v-if="resource.type == 'html'">
                    <div class="w-full flex justify-between items-center">
                        <div class="w-1/2">
                            <label class="text-gray-800 font-semibold">Html Snipet</label>
                        </div>
                        <div class="w-1/2">
                            <textarea class="w-full p-2 border border-gray-400 rounded" v-model="resource.html"></textarea>
                            <span v-if="errors.html" class="text-red-500">{{ errors.html }}</span>
                        </div>
                    </div>
                </div>
                <div class="w-full mt-10" v-if="resource.type == 'url'">
                    <div class="w-full flex justify-between items-center">
                        <div class="w-1/2">
                            <label class="text-gray-800 font-semibold">Resource URL</label>
                        </div>
                        <div class="w-1/2">
                            <input type="text" class="w-full p-2 border border-gray-400 rounded" v-model="resource.url">
                            <span v-if="errors.url" class="text-red-500">{{ errors.url }}</span>
                        </div>
                    </div>
                </div>
                <!-- checkbox -->
                <div class="w-full mt-10" v-if="resource.type == 'url'">
                    <div class="w-full flex justify-start items-start ">
                        <div class="w-1/2">
                            <label class="text-gray-800 font-semibold">Open URL in new tab</label>
                        </div>
                        <div class="w-1/2">
                            <input type="checkbox" class="p-2 mr-2 border border-gray-400 rounded" v-model="resource.new_tab">
                            <span class="w-1/2">Open uRL in new tab</span>
                        </div>
                    </div>
                </div>
                <!-- button -->
                <div class="w-full mt-10">
                    <div class="w-full flex justify-between items-center">
                        <div class="w-1/2">
                            <label class="text-gray-800 font-semibold">&nbsp;</label>
                        </div>
                        <div class="w-1/2">
                            <button @click="edit?$emit('edit', resource): $emit('save', resource)" class="w-full p-2 bg-blue-500 text-white rounded hover:bg-blue-600">{{edit? "Edit" : "Add"}} Resource</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            errors:{
                type: Object,   
            },
            edit: {
                type: Boolean,
                default: false
            },
            Editresource: {
                type: Object,
                default: function () {
                    return {
                        id: '',
                        title: '',
                        type: '',
                        pdf: '',
                        description: '',
                        html: '',
                        url: '',
                        new_tab: false
                    }
                }
            }
        },
        data() {
            return {
                resource: {
                    id: this.Editresource.id,
                    title: this.Editresource.title,
                    type: this.Editresource.type,
                    description: this.Editresource.description,
                    html: this.Editresource.html,
                    url: this.Editresource.url,
                    new_tab: this.Editresource.new_tab
                }
            }
        },
        methods: {
            changeType(){
                if(this.resource.type == 'pdf'){
                    this.resource.html = '';
                    this.resource.url = '';
                }else if(this.resource.type == 'html'){
                    this.resource.pdf = '';
                    this.resource.url = '';
                }else if(this.resource.type == 'url'){
                    this.resource.pdf = '';
                    this.resource.html = '';
                }
            },
        },

    }
</script>
