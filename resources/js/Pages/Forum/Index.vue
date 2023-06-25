<script setup>
import {Head, router} from '@inertiajs/vue3';
import ForumLayout from "@/Layouts/ForumLayout.vue";
import Discussion from "@/Pages/Forum/Discussion.vue";
import Pagination from "@/Pages/Common/Pagination.vue";
import Navigation from "@/Pages/Common/Navigation.vue";
import _omitby from 'lodash.omitby'
import _empty from 'lodash.isempty'

defineProps({
    discussions: Object
})

const filterTopic = (e) => {
    router.visit(route('home', _omitby({topic: e.target.value}, _empty)), {
        preserveScroll: true
    })
}
</script>

<template>
    <Head title="Discussion"/>
    <ForumLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-start">
                        <div class="p-6 text-gray-900">You're logged in!</div>
                        <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg" @change="filterTopic">
                            <option value="">Choose a topic</option>
                            <option :selected="discussions.queries.topic == topic.slug" :value="topic.slug" v-for="topic in $page.props.topics.data" :key="topic.id">
                                {{ topic.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
                  <Discussion v-for="discussion in discussions.data" :key="discussion.id" :discussion="discussion"/>

                </div>
                <Pagination :links="discussions.meta.links"></Pagination>
            </div>

        </div>
        <template #side>
           <Navigation :queries=discussions.queries></Navigation>
        </template>

    </ForumLayout>
</template>
