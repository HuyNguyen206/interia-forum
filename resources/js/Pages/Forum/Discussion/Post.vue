<script setup>

import useCreateReply from "@/Composables/useCreateReply.js";

defineProps({
    post: Object,
    discussion: Object
})
const {showCreateDiscussionReply} = useCreateReply()
</script>

<template>
        <div class="flex items-start">
            <div class="flex-grow">
                <div class="">

                    <div class="rounded-lg px-2 py-2 bg-gray-200 text-gray-700 text-sm">
                        <div class="flex space-x-2">
                            <img v-if="post.user" :src="post.user.avatar" alt="" class="w-7 h-7 rounded-full">
                            <span :class="{'text-red-300' : !post.user}">{{post.user?.username || '[Deleted user]'}}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 text-sm mt-1 inline-block">{{post.created_at}}</span>
                            <p class="markdown mt-4" v-html="post.body_markdown"></p>
                        </div>

                        <a href="" v-if="discussion.can.reply" @click.prevent="showCreateDiscussionReply(discussion)" class="text-blue-500">Reply</a>

                    </div>
                </div>
            </div>
        </div>
</template>
