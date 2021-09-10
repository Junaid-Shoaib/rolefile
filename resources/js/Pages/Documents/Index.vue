<template>
    <app-layout>
        <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
            {{ $page.props.flash.success }}
        </div>
        <div>
        {{$page.props.parent_id}}
        </div>
        <div class="m-2">
            <button @click="create" class="inline-block border rounded-lg ml-2 p-2 bg-gray-600 hover:bg-gray-700 text-green-300 hover:text-green-200 m-2">Upload File</button>
            <form @submit.prevent="form.post('/folder',{
                        preserveState: false,
                    })" class="inline-block">
                <input type="text" v-model="form.name" class="border border-gray-300 rounded-lg ml-2" placeholder="Enter Folder Name">
                <div v-if="form.errors.name">{{ form.errors.name }}</div>
                <button type="submit" :disabled="form.processing" class="border rounded-lg ml-2 p-2 bg-gray-600 hover:bg-gray-700 text-green-300 hover:text-green-200">Create Folder</button>
            </form>
        </div>
        <div id="app" class="w-60 float-left m-2">
            <treeselect v-model="value" :multiple="false" :alwaysOpen="true" :options="fold" v-on:select="treeChange"/>
        </div>
        <div class="float-left">
            <table class="border border-gray-300 m-2 rounded bg-white">
                <thead>
                    <tr class="bg-indigo-100">
                        <th class="py-1 px-2">Name</th>
                        <th class="py-1 px-2">Path</th>
                        <th class="py-1 px-2">Parent</th>
                        <th class="py-1 px-2">Is Folder?</th>
                        <th class="py-1 px-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id" class="hover:bg-gray-100">
                        <td class="py-1 px-2"><a :href="item.path">{{item.name}}</a></td>
                        <td class="py-1 px-2"><a :href="item.path">{{item.path}}</a></td>
                        <td class="py-1 px-2"><a :href="item.path">{{item.parent_id}}</a></td>
                        <td class="py-1 px-2">{{(item.is_folder)?"Yes":"No"}}</td>
                        <td class="py-1 px-2">
                            <inertia-link v-if="item.is_folder" class="border border-indigo-400 bg-indigo-200 hover:bg-indigo-400 hover:text-white rounded px-2 py-1 m-1" :href="route('documents.edit', item.id)">
                                <span>Edit</span>
                            </inertia-link>
                            <button class="border border-indigo-400 bg-indigo-200 hover:bg-indigo-400 hover:text-white rounded px-2 py-1 m-1" @click="destroy(item.id)">
                                <span>Delete</span>
                            </button>        
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
  

    </app-layout>
</template>

<script>
    import { useForm } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import Treeselect from 'vue3-treeselect'
    import 'vue3-treeselect/dist/vue3-treeselect.css'
    import _ from 'lodash'
 
 export default {
        setup () {
            const form = useForm({
                name: null,
            })
            return { form }
        },

        components: {
            AppLayout,
            Treeselect,
        },

        props: {
            data:Object,
            fold:Object,
        },

        data(){
            return {
                value: null,
            }
        },

        methods: {

            create() {
            this.$inertia.get(route('documents.create'))
            }, 

            destroy(id) {
            this.$inertia.delete(route('documents.destroy', id))
            },

            treeChange(node, instanceId){
                this.value = node.id
//                alert(node.label + '---' + node.id*2  + '---' + this.value)
                this.$inertia.get(route('documents', {'fold':this.value}))
            },
        },
    }
</script>
