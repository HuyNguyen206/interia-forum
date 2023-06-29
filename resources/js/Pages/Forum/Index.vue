<script setup>
import {Head, router} from '@inertiajs/vue3';
import ForumLayout from "@/Layouts/ForumLayout.vue";
import Discussion from "@/Pages/Forum/Discussion.vue";
import Pagination from "@/Pages/Common/Pagination.vue";
import Navigation from "@/Pages/Common/Navigation.vue";
import _omitby from 'lodash.omitby'
import _empty from 'lodash.isempty'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import useCreateDiscussion from "@/Composables/useCreateDiscussion.js";
import TextInput from "@/Components/TextInput.vue";
import {onMounted, ref, watch} from "vue";

const props = defineProps({
    discussions: Object,
    search: String
})

const search = ref(null)

onMounted(() => {
    search.value = props.search
})

watch(search, function (query){
    router.reload({
        data: {'search' : query},
        preserveScroll: true
    })

    // _debounce(() => {
    //     router.reload({
    //         data: {'search' : query},
    //         preserveScroll: true
    //     })
    // }, 200)
})

const filterTopic = (e) => {
    router.visit(route('home', _omitby({topic: e.target.value}, _empty)), {
        preserveScroll: true
    })
}

const {visible, showCreateDiscussionForm} = useCreateDiscussion()
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
                    <div class="flex justify-between space-x-2">
                        <div class="text-gray-900 flex-grow">
                            <TextInput v-model="search" placeholder="Search discussion" class="w-full" type="search" id="search"></TextInput>
                        </div>
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
            <PrimaryButton v-if="$page.props.auth.user" @click.prevent="showCreateDiscussionForm()" class="mt-4">Start discussion</PrimaryButton>
           <Navigation :queries=discussions.queries></Navigation>
        </template>

    </ForumLayout>
</template>
