<script setup>

import FixedFormWrapper from "@/Pages/Common/FixedFormWrapper.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Textarea from "@/Components/Textarea.vue";

const form = useForm({
    title: '',
    topic_id: '',
    body: '',
});

</script>

<template>
    <FixedFormWrapper>
        <template #header>
            <h1 class="text-lg font-medium">New discussion</h1>
        </template>

        <template #main>
            <form action="">
                <div class="flex justify-between items-end space-x-2">
                    <div class="flex-grow">
                        <InputLabel for="title" value="Title"/>

                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.title"
                            required
                        />

                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>
                    <select v-model="form.topic_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Select topic</option>
                        <option :value="topic.id" v-for="topic in $page.props.topics.data" :key="topic.id">
                            {{ topic.name }}
                        </option>
                    </select>
                </div>
                <div class="mt-4 ">
                    <InputLabel for="body" value="Body"/>
                    <Textarea cols="30" rows="4" class="w-full"/>
                </div>
            </form>
        </template>

        <template #button>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FixedFormWrapper>
</template>

<style scoped>

</style>
