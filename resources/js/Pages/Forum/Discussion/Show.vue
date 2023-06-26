<script setup>
import {Head} from '@inertiajs/vue3';
import ForumLayout from "@/Layouts/ForumLayout.vue";
import Post from "@/Pages/Forum/Discussion/Post.vue";
import Pagination from "@/Pages/Common/Pagination.vue";
import Navigation from "@/Pages/Common/Navigation.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import useCreateDiscussion from "@/Composables/useCreateDiscussion.js";
import useCreateReply from "@/Composables/useCreateReply.js";

defineProps({
    discussion: Object,
    posts: Object
})

const {visible, showCreateDiscussionForm} = useCreateDiscussion()
const { showCreateDiscussionReply} = useCreateReply()

</script>

<template>
    <Head :title="discussion.data.title"/>

    <ForumLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items-start p-6 text-gray-900">
                        <div class="flex items-center space-x-4">

                            <div class="rounded-lg px-2 py-0.5 bg-gray-200 text-gray-700 text-sm">
                                {{ discussion.data.topic.name }}
                            </div>
                            <span class="font-semibold">
                          <template v-if="discussion.data.is_pinned">
                        [Pinned]
                    </template>
                         {{ discussion.data.title }}
                    </span>

                        </div>
                        <span class="inline-block text-sm">
                {{ discussion.data.posts_count }}
            </span>
                    </div>
                </div>
                <div class="space-y-4 mt-2">
                    <Post v-for="post in posts.data" :key="post.id" :post="post" :discussion="discussion.data"></Post>
                </div>
                <Pagination :links="posts.meta.links"></Pagination>
            </div>

        </div>
        <template #side>
            <PrimaryButton v-if="discussion.data.can.reply" @click.prevent="showCreateDiscussionReply(discussion.data)" class="mt-4">Reply</PrimaryButton>
            <Navigation :queries="{}"></Navigation>
        </template>

    </ForumLayout>
</template>
