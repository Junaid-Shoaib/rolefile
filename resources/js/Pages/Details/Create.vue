<template>
    <app-layout>
        <div class="">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-col">
                    <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
                        <label class="w-28 inline-block text-right mr-4">Date:</label>
                        <datepicker v-model="form.date" class="pr-2 pb-2 w-44 rounded-md leading-tight" label="date"/>
                        <div v-if="errors.date">{{ errors.date }}</div>
                    </div>
                    <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
                        <label class="w-28 inline-block text-right mr-4">Voucher:</label>
                        <input type="text" v-model="form.voucher" class="pr-6 pb-8 w-full lg:w-1/2" label="voucher"/>
                        <div v-if="errors.voucher">{{ errors.voucher }}</div>
                    </div>
                    <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
                        <label class="w-28 inline-block text-right mr-4">Particular:</label>
                        <input type="text" v-model="form.particular" class="pr-6 pb-8 w-full lg:w-1/2" label="particular"/>
                        <div v-if="errors.particular">{{ errors.particular }}</div>
                    </div>
                    <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
                        <label class="w-28 inline-block text-right mr-4">Amount:</label>
                        <input type="text" v-model="form.amount" class="pr-6 pb-8 w-full lg:w-1/2" label="amount"/>
                        <div v-if="errors.amount">{{ errors.amount }}</div>
                    </div>
                    <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
                        <label class="w-28 inline-block text-right mr-4">Account ID:</label>
                        <input type="text" v-model="form.account_id" class="pr-6 pb-8 w-full lg:w-1/2" label="account_id"/>
                        <div v-if="errors.account_id">{{ errors.account_id }}</div>
                    </div>
                    <div class="p-2 mr-2 mb-2 mt-4 ml-6 flex flex-wrap">
                        <table class="table border">
                            <thead class="">
                                <tr v-for='col in cols' :key="col.id">                            
                                    <th>
                                    <input  v-model="col.name"  type="text" />
                                    </th>
                                </tr>                        
                            </thead>
                            <tbody>
                                <tr v-for='col in cols' :key="col.id">                            
                                    <td>
                                    <input  v-model="col.name"  type="text" />
                                    </td>
                                </tr>                        
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <button class="border bg-indigo-300 rounded-xl px-4 py-2 m-4" type="submit">Create Detail</button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Datepicker from 'vue3-datepicker'

    export default {
        components: {
            AppLayout,
            Datepicker,
        },

        props: {
            errors : Object    
        },

        data() {
            return {
                form: this.$inertia.form({
                    date: new Date(),
                    voucher: null,
                    particular: null,
                    amount: null,
                    cols: {'name':'hello','name':'world'},
//                    cols: Array,
                    account_id: null,
                }),
            }
        },
        methods: {
            submit() {
                this.form.post(route('details.store'))
            },
        },
    }
</script>
