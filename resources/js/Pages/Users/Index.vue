<template>
    <app-layout>
        <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
            {{ $page.props.flash.success }}
        </div>
        <div><h1>hell, {{hello}}, {{can}}</h1></div>
        <button @click="create">Create</button>        
        <div class="">
            <table class="shadow-lg border m-4 rounded-xl">
                <thead>
                    <tr class="bg-indigo-100">
                        <th class="py-2 px-4 border">Name</th>
                        <th class="py-2 px-4 border">Email</th>
                        <th class="py-2 px-4 border">Can Edit</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id">
                        <td class="py-2 px-4 border">{{item.name}}</td>
                        <td class="py-2 px-4 border">{{item.email}}</td>
                        <td class="py-2 px-4 border">{{item.can.edit_articles}}</td>
                        <td class="py-2 px-4 border">
                            <inertia-link v-if="item.can.edit_articles" class="border bg-indigo-300 rounded-xl px-4 py-2 m-4" :href="route('users.edit', item.id)">
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

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
 
 export default {
        components: {
            AppLayout,
        },

        props: ['hello','data','can'],

        data(){
            return {
            }
        },

        methods: {

            create() {
            this.$inertia.get(route('users.create'))
            }, 

            destroy(id) {
            this.$inertia.delete(route('users.destroy', id))
            },

        },
    }
</script>
