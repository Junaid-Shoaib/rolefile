<template>
    <app-layout>
        <div class="">
            <form @submit.prevent="submit">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <input type="text" v-model="form.name" class="pr-6 pb-8 w-full lg:w-1/2" label="name"/>
                    <div v-if="errors.name">{{ errors.name }}</div>
                    <input type="text" v-model="form.path" class="pr-6 pb-8 w-full lg:w-1/2" label="path"/>
                    <div v-if="errors.path">{{ errors.path }}</div>

                <input type="file" v-on:change="onFileChange"/>
                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                {{ form.progress.percentage }}%
                </progress>


                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <button class="border bg-indigo-300 rounded-xl px-4 py-2 m-4" type="submit">Create Document</button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },

        props: {
            errors : Object    
        },

        data() {
            return {
                form: this.$inertia.form({
                    name: null,
                    path: null,
                    avatar: null,
                }),
            }
        },
        methods: {
            submit() {
//            this.$inertia.post(this.route('documents.store'), this.form)
            this.form.post(route('documents.store'))
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.form.avatar = files[0];
            },
        },
    }
</script>
