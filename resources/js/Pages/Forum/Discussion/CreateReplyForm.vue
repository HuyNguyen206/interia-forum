<script setup>

import FixedFormWrapper from "@/Pages/Common/FixedFormWrapper.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Textarea from "@/Components/Textarea.vue";
import useCreateReply from "@/Composables/useCreateReply.js";
import {Mentionable} from "vue-mention";
import useMention from "@/Composables/useMention.js";
import {onMounted} from "vue";

const {hideCreateDiscussionReply, form, discussion, extraData} = useCreateReply()

const createReply = function () {
    console.log(extraData)
    form.post(route('posts.store', {discussion: discussion.value.id}), {
        onSuccess: () => {
            form.reset()
            hideCreateDiscussionReply()
        }
    })
}
const {items, loading, loadUsers} = useMention()
const {postAuthor} = useCreateReply()
onMounted(() => {
    if (!postAuthor.value?.username) {
        return
    }

    form.body = '@'+postAuthor.value.username
})

</script>

<template>
    <FixedFormWrapper @submit.prevent="createReply" :body="form.body">
        <template #header>
            <div class="flex justify-between">
                <h1 class="text-lg font-medium">New Reply to {{discussion.title}}</h1>
                <div @click="hideCreateDiscussionReply">&times;</div>
            </div>

        </template>
        <template #main="{markdownPreviewEnabled}">
            <div class="mt-4">
                <InputLabel for="body" value="Body"/>
                <Mentionable
                    :keys="['@']"
                    :items="items"
                    offset="6"
                    insert-space
                    filtering-disabled
                    @search="loadUsers($event)"
                >
                    <Textarea v-if="!markdownPreviewEnabled" v-model="form.body" cols="30" id="body"  class="w-full h-48 rounded-lg align-top"/>

                    <template #no-result>
                        <div class="p-2">
                            {{ loading ? 'Loading...' : 'No result' }}
                        </div>
                    </template>

                    <template #item-@="{ item }">
                        <div class="item">
                            {{ item.value }}
                            <span class="dim">
          ({{ item.label }})
        </span>
                        </div>
                    </template>
                </Mentionable>
                <InputError class="mt-2" :message="form.errors.body"/>
            </div>
        </template>

        <template #button>
            <PrimaryButton  :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>

            <PrimaryButton  @click.prevent="hideCreateDiscussionReply">
                Cancel
            </PrimaryButton>
        </template>

    </FixedFormWrapper>
</template>

<style scoped>

</style>
