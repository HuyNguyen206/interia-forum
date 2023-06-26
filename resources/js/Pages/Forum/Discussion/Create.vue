<script setup>

import FixedFormWrapper from "@/Pages/Common/FixedFormWrapper.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Textarea from "@/Components/Textarea.vue";
import useCreateDiscussion from "@/Composables/useCreateDiscussion.js";

const {hideCreateDiscussionForm, form} = useCreateDiscussion()
const createDiscussion = function () {
    form.post(route('discussions.store'), {
        onSuccess: () => {
            form.reset()
            hideCreateDiscussionForm()
        }
    })
}
</script>

<template>
    <FixedFormWrapper @submit.prevent="createDiscussion" :body="form.body">
        <template #header>
            <div class="flex justify-between">
                <h1 class="text-lg font-medium">New discussion</h1>
                <div @click="hideCreateDiscussionForm">&times;</div>
            </div>

        </template>
            <template #main="{markdownPreviewEnabled}">
                <div class="flex justify-between items-end space-x-2 mb-2">
                    <div class="flex-grow">
                        <InputLabel for="title" value="Title"/>

                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title"
                        />
                        <InputError class="mt-2" :message="form.errors.title"/>
                    </div>
                    <div>
                        <select v-model="form.topic_id"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Select topic</option>
                            <option :value="topic.id" v-for="topic in $page.props.topics.data" :key="topic.id">
                                {{ topic.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.topic_id"/>
                    </div>
                </div>
                <div class="mt-4">
                    <InputLabel for="body" value="Body"/>
                    <Textarea v-if="!markdownPreviewEnabled" v-model="form.body" cols="30" id="body"  class="w-full h-48 rounded-lg align-top"/>
                    <InputError class="mt-2" :message="form.errors.body"/>
                </div>
            </template>

            <template #button>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create
                </PrimaryButton>
                <PrimaryButton  @click.prevent="hideCreateDiscussionForm">
                    Cancel
                </PrimaryButton>
            </template>

    </FixedFormWrapper>
</template>

<style scoped>

</style>
