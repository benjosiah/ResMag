<template>
    <div id="app">
        <header class="w-full h-32 bg-white shadow-md pt-10">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <router-link to="/" class="text-2xl font-bold text-gray-800">
                       Rosource Managemer
                    </router-link>
                </div>
                <div class="flex items-center">
                    <router-link to="" class="text-2xl font-bold text-gray-800">
                        Admin
                    </router-link>
                </div>
            </div>
        </header>

        <delete-up
            :open="openDelete"
            :message="message"
            @close="closeDelete"
            @delete="deleteResource"
        />
        <message
            :open="message.open"
            :message="message.text"
            :type="message.type"
        />
        
        <div class="container m-auto w-full h-auto mt-14 py-7">
            <div class="w-full flex justify-between items-center px-4 ">
                <h2 class="font-semibold text-2xl">Dashboard</h2>
                <button @click.prevent="showAddModal" class="p-4 bg-blue-500 text-white rounded font-semibold hover:bg-blue-700">
                    <i class="fas fa-plus"></i>
                    Add Resource
                </button>
            </div>

            <add-resource v-if="addModal" class="fixed lg:w-1/3 md:1/2 w-full top-0 left-0 right-0 m-auto border-t fadeIn"
                @close="closeAddModal"
                @save="addResource"
                @edit="editResource"  
                :Editresource="resource"
                :edit="edit"
                :errors="errors"          
            >

            </add-resource>
            <div class="flex justify-between items-center mb-10 mt-10 mx-auto">
                <div class="flex items-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Filter by type
                    </h2>
                </div>
                <div class="flex items-center">
                    <select @change="filterResource" id="filter" v-model="sort" class="w-full h-10 p-2 bg-white border border-gray-400 rounded-lg">
                        <option value="">All</option>
                        <option value="pdf">PDF</option>
                        <option value="html">HTML</option>
                        <option value="url">URL</option>
                    </select>
                </div>
            </div>

            <div class="w-full mt-16 m-auto">
                <div class="w-full bg-white shadow-lg rounded p-10">
                    <div class="w-full">
                        <h3 class="font-semibold text-2xl">Resources</h3>
                    </div>
                    <div class="w-full mt-10">
                        <table class="w-full m-auto">
                            <thead>
                                <tr>
                                    <th class="text-left p-2">S/N</th>
                                    <th class="text-left p-2 w-1/6">Title</th>
                                    <th class="text-left p-2 w-1/6">Type</th>
                                    <th class="text-left p-2 w-2/6">Description</th>
                                    <th class="text-left p-2 w-1/6">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(resource, index) in resources" :key="index">
                                    <td class="text-left p-2">{{ index + 1 }}</td>
                                    <td class="text-left p-2">{{ resource.title }}</td>
                                    <td class="text-left p-2">{{ resource_types[resource.type]}}</td>
                                    <td class="text-left p-2">{{ resource.description }}</td>
                                    <td class="text-left p-2">
                                        <button @click="openUrl(resource.url, resource.new_tab)" v-if="resource.type=='url'" class="p-2 bg-gray-100 text-black rounded font-semibold mx-1 hover:bg-gray-200">
                                            <i class="fas fa-link"></i>
                                        </button>
                                        <button @click="download(resource.pdf)" v-if="resource.type=='pdf'" class="p-2 bg-gray-100 text-black rounded font-semibold mx-1 hover:bg-gray-100">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button @click="copyToClipboard(resource.html)" v-if="resource.type == 'html'" class="p-2 bg-gray-100 text-black rounded font-semibold mx-1 hover:bg-gray-200">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button @click="showedit(resource)" class="w-9 p-2 bg-blue-500 text-white rounded mx-1 hover:bg-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button @click="deletemodal(resource)" class="w-9 p-2 bg-red-500 text-white rounded hover:bg-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                   </div> 
            </div>

        </div>
    </div>
</template>
<script> 
    import { Head } from '@inertiajs/inertia-vue3'
    import addResource from './components/addResource.vue'
    import deleteUp from './components/deleteComfirmation.vue'
    import message from './components/message.vue';
    export default {
        name: 'Dashboard', 
        props: {
            resources: {
                type: Object,
                required: true
            },
            errors: {
                type: Object,
            },
            filter: {
                type: String,
            }
        },
        components: {
            Head,
            addResource,
            deleteUp,
            message
        },
        data() {
            return {
                resource:null,
                addModal: false,
                edit:false,
                resource_types:{
                    'url': 'URL',
                    'pdf': 'PDF',
                    'html': 'HTML Snippet'
                },
                openDelete: false,
                resourceToDelete: null,
                message: {
                    open: false,
                    type: '',
                    text: ''
                },
                sort: this.filter
            }
        },
        methods: {
            showAddModal(){
                this.addModal = true
            },
            closeAddModal(){
                this.$inertia.get('/admin')
            },

            addResource(resource){
                this.$inertia.post('/resources', resource, {
                    onSuccess: () => {
                        this.emptyResource()
                        this.toast("Resource added succefully")
                    },
                    onError: (error) => {
                        if(error.error){
                            this.emptyResource()
                            this.toast(error.error, 'error')
                        }
      
                    }
                })  
            },
            editResource(resource){
                this.$inertia.post('/resources/'+resource.id, resource, {
                    onSuccess: () => {
                        this.emptyResource()
                        this.toast("Resource edited succefully")
                    },
                    onError: (error) => {
                        if(error.error){
                            this.emptyResource()
                            this.toast(error.error, 'error')
                        }
                    }
                })  
            },
            copyToClipboard(text) {
                var dumptext = document.createElement("textarea");
                document.body.appendChild(dumptext);
                dumptext.value = `${text}`;
                dumptext.select();
                document.execCommand("copy");
                document.body.removeChild(dumptext);
                this.toast(`${text} copied to clipboard`)
            },
            openUrl(url, is_blank){
                window.open(url, is_blank ? '_blank' : '_self')
            },
            download(url){
                window.open(url, '_blank')
            },
            showedit(resource){
                this.edit = true
                this.resource = resource
                this.addModal = true
            },
            deleteResource(){
                this.$inertia.post(`/resources/${this.resourceToDelete.id}`, {
                    _method: 'delete'
                }, {
                    onSuccess: () => {
                        this.openDelete = false
                        this.toast("Resource deleted succefully")
                    },

                    onError: (error) => {
                        this.openDelete = false
                        this.toast(error.error, 'error')
                    }
                })
            },
            closeDelete(){
                this.openDelete= false
                this.resourceToDelete= null
            },
            deletemodal(resource){
                this.openDelete = true
                this.resourceToDelete = resource
            },
            toast(text, type='success'){
                this.message.text = text
                this.message.open = true
                this.message.type = type
                setInterval(()=>{
                    this.message.open = false
                }, 3000)
            },
            filterResource(){
                this.$inertia.replace(`/admin?filter=${this.sort}`)
            },
            emptyResource(){
                this.resource = null
                this.addModal = false
                this.edit = false
            }
              
        }
    }
</script>
<style>
    .fadeIn{
        animation: fadein 2s;
    }
    @keyframes fadein {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>