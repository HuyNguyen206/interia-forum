<script setup>

import useCreateReply from "@/Composables/useCreateReply.js";
import {router, useForm} from "@inertiajs/vue3";
import {onMounted, onUpdated, ref} from "vue";
import Textarea from "@/Components/Textarea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";

const updatePost = () => {
    editForm.patch(route('posts.update', props.post), {
        onSuccess: () => {
            isEdit.value = false
        },
        preserveScroll: true
    })

}

const deletePost = () => {
    if (!confirm('Are you sure to delete this post?')) {
        return;
    }

    router.delete(route('posts.destroy', props.post), {
        preserveScroll: true
    })

}

const toggleBestReply = () => {
    router.patch(route('discussions.mark-best-reply', {post: isBestReply.value ? null : props.post, discussion: props.discussion}), {}, {
        preserveScroll: true
    })

}
const props = defineProps({
    post: Object,
    discussion: Object
})

const isBestReply = ref(null);

onMounted(() => {
    isBestReply.value =  props.discussion.best_reply?.id === props.post.id
})

onUpdated(() => {
    isBestReply.value =  props.discussion.best_reply?.id === props.post.id
})
const {showCreateDiscussionReply} = useCreateReply()

const editForm = useForm({
    body: props.post.body
})

const isEdit = ref(false)
</script>

<template>
        <div class="flex items-start" :id="`post_${post.id}`">
            <div class="flex-grow relative rounded-md" :class="{'border-green-800 border-2': isBestReply}">
                    <div class="rounded-lg px-2 py-2 bg-gray-200 text-gray-700 text-sm">
                        <div class="flex space-x-2">
                            <img v-if="post.user" :src="post.user.avatar" alt="" class="w-7 h-7 rounded-full">
                            <span :class="{'text-red-300' : !post.user}">{{post.user?.username || '[Deleted user]'}}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 text-sm mt-1 inline-block">{{post.created_at}}</span>
                            <p v-if="!isEdit" class="markdown mt-4" v-html="post.body_markdown"></p>
                            <form @submit.prevent="updatePost" v-else >
                                    <Textarea v-model="editForm.body" cols="30" id="body"  class="w-full h-48 rounded-lg align-top"/>
                                    <InputError class="mt-2" :message="editForm.errors.body"/>
                                <div class="flex space-x-2 my-2">
                                    <PrimaryButton type="submit">Update</PrimaryButton>
                                    <PrimaryButton @click.prevent="isEdit = false; editForm.body = post.body">Cancel</PrimaryButton>
                                </div>

                            </form>
                        </div>
                        <div class="flex justify-start space-x-2">
                            <button v-if="discussion.can.reply" @click.prevent="showCreateDiscussionReply(discussion, post.user)" class="text-blue-500">Reply</button>
                            <button v-if="post.can.edit" @click.prevent="isEdit = true" class="text-blue-500">Edit</button>
                            <button v-if="post.can.delete" @click.prevent="deletePost" class="text-blue-500">Delete</button>
                            <button v-if="discussion.can.mark_best_reply" @click="toggleBestReply" class="text-blue-500"> {{isBestReply ? 'UnMark' : 'Mark best reply'}}</button>
                        </div>


                    </div>
                <div class="absolute top-0 right-0 w-30 h-18 p-2 bg-green-800 text-white font-bold tracking-wide rounded-bl-md" v-if="isBestReply">Best answer</div>
            </div>

        </div>
</template>
