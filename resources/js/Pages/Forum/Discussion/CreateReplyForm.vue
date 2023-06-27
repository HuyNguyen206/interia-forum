<script setup>

import FixedFormWrapper from "@/Pages/Common/FixedFormWrapper.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Textarea from "@/Components/Textarea.vue";
import useCreateReply from "@/Composables/useCreateReply.js";

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
                <Textarea v-if="!markdownPreviewEnabled" v-model="form.body" cols="30" id="body"  class="w-full h-48 rounded-lg align-top"/>
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
