<template>
    <app-layout>
        <div v-if="$page.props.flash.success" class="bg-green-600 text-white">
            {{ $page.props.flash.success }}
        </div>
        <button @click="create" class="border bg-gray-800 text-white px-4 py-2 rounded-md">Create</button>        
        <div class="">
            <table class="shadow-lg border rounded-xl">
                <thead>
                    <tr class="bg-indigo-100">
                        <th class="py-2 px-4 border">Index</th>
                        <th class="py-2 px-4 border">Date</th>
                        <th class="py-2 px-4 border">Voucher</th>
                        <th class="">
                            <table class="table-auto">
                                <tr class="inline text-center" v-for="(col, j) in col1" :key="j">
                                    <td class="w-28">{{col}}</td>
                                </tr>
                            </table>
                        </th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in data" :key="i">
                        <td class="py-2 px-4 border">{{i+1}}</td>
                        <td class="py-2 px-4 border">{{item.date}}</td>
                        <td class="py-2 px-4 border">{{item.voucher}}</td>
                        <td class="">
                            <table class="table-auto">
                                <tr class="inline text-center" v-for="(col, j) in item.cols" :key="j">
                                    <td class="w-28">{{col.value}}</td>
                                </tr>
                            </table>
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

        props: [
            'data',
            'col1',
            'col2',
        ],

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
