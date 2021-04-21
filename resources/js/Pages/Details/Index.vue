<template>
    <app-layout>
        <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
            {{ $page.props.flash.success }}
        </div>
        <button @click="create">Create</button>        
        <div class="">
            <table class="shadow-lg border m-4 rounded-xl">
                <thead>
                    <tr class="bg-indigo-100">
                        <th class="py-2 px-4 border">Date</th>
                        <th class="py-2 px-4 border">Voucher</th>
                        <th class="py-2 px-4 border">Cols</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in data" :key="item.id">
                        <td class="py-2 px-4 border">{{item.date}}</td>
                        <td class="py-2 px-4 border">{{item.voucher}}</td>
                        <td class="py-2 px-4 border">{{item.cols}}
                            <ul v-for="col in item.cols" :key="col.id">
                                <li>{{col.key}} - {{col.value}}</li>
                            </ul>
                        </td>
                        <td class="py-2 px-4 border">
                            <inertia-link class="border bg-indigo-300 rounded-xl px-4 py-2 m-4" :href="route('details.edit', item.id)">
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

        props: ['data'],

        data(){
            return {
            }
        },

        methods: {

            create() {
            this.$inertia.get(route('details.create'))
            }, 

            destroy(id) {
            this.$inertia.delete(route('details.destroy', id))
            },

        },
    }
</script>
