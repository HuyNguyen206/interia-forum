<script setup>
import {Head} from '@inertiajs/vue3';
import ForumLayout from "@/Layouts/ForumLayout.vue";
import Discussion from "@/Pages/Forum/Discussion.vue";

defineProps({
    discussions: Array
})
</script>

<template>
    <Head title="Dashboard"/>

    <ForumLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-start">
                        <div class="p-6 text-gray-900">You're logged in!</div>
                        <select id="countries"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg">
                            <option value="">Choose a topic</option>
                            <option :value="topic.id" v-for="topic in $page.props.topics.data" :key="topic.id">
                                {{ topic.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                  <Discussion v-for="discussion in discussions.data" :key="discussion.id" :discussion="discussion"/>
                </div>
            </div>

        </div>
        <template #side>
            <div class="py-12">
                <div class="sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">Side</div>
                    </div>
                </div>
            </div>
        </template>

    </ForumLayout>
</template>
