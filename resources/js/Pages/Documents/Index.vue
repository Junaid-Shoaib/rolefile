<template>
    <app-layout>
        <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
            {{ $page.props.flash.success }}
        </div>
        <div id="app" class="w-60 float-left m-2">
            <treeselect v-model="value" :multiple="false" :alwaysOpen="true" :options="data" v-on:select="treeChange"/>
        </div>
         <button @click="create" class="border rounded-lg ml-2 p-2 bg-gray-600 hover:bg-gray-700 text-green-300 hover:text-green-200 m-2">Create</button>
        <div class="float-left">
            <table class="shadow-lg border m-2 rounded-xl">
                <thead>
                    <tr class="bg-indigo-100">
                        <th class="py-2 px-4 border">Name</th>
                        <th class="py-2 px-4 border">Path</th>
                        <th class="py-2 px-4 border">Is Folder?</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id">
                        <td class="py-2 px-4 border"><a :href="item.path">{{item.name}}</a></td>
                        <td class="py-2 px-4 border"><a :href="item.path">{{item.path}}</a></td>
                        <td class="py-2 px-4 border">{{item.is_folder}}</td>
                        <td class="py-2 px-4 border">
                            <inertia-link v-if="item.read_only" class="border bg-indigo-300 rounded-xl px-4 py-2 m-4" :href="route('documents.edit', item.id)">
                                <span>Edit</span>
                            </inertia-link>        
                            <button class="border bg-indigo-300 rounded-xl px-4 py-2 m-4" @click="destroy(item.id)">
                                <span>Delete</span>
                            </button>        
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
  
  <form @submit.prevent="form.post('/folder',{
            preserveState: false,
        })">
    <input type="text" v-model="form.name" class="border rounded-lg ml-2">
    <div v-if="form.errors.name">{{ form.errors.name }}</div>
    <button type="submit" :disabled="form.processing" class="border rounded-lg ml-2 p-2 bg-gray-600 hover:bg-gray-700 text-green-300 hover:text-green-200">Create Folder</button>
  </form>

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
                alert(node.path + '---' + node.id*2)
            },
        },
    }
</script>
