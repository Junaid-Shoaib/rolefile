<template>
    <app-layout>
        <div class="">
            <form @submit.prevent="form.put(route('posts.update', post.id))">
                <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
                    <input type="text" v-model="form.title" class="pr-6 pb-8 w-full lg:w-1/2" label="title"/>
                    <div v-if="errors.title">{{ errors.title }}</div>
                    <input type="text" v-model="form.body" class="pr-6 pb-8 w-full lg:w-1/2" label="body"/>
                    <div v-if="errors.body">{{ errors.body }}</div>
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <button class="border bg-indigo-300 rounded-xl px-4 py-2 m-4" type="submit">Update Post</button>
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
            errors : Object,
            post : Object    
        },

        data() {
            return {
                form: this.$inertia.form({
                    title: this.post.title,
                    body: this.post.body,
                }),
            }
        },
    }
</script>
