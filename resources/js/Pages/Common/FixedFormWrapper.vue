<script setup>

import {ref, watch} from "vue";
import MarkdownShorcutToolbar from "@/Pages/Common/MarkdownShorcutToolbar.vue";

const props = defineProps({
    body: String
})
const markdownPreviewEnabled = ref(false)
const bodyMarkdownPreview = ref('')

watch(markdownPreviewEnabled, (enable) => {
    if(!enable) {
        console.log(enable)
        return;
    }

axios.post(route('posts.preview-markdown'), {
    body: props.body
})
    .then((res) => {
        bodyMarkdownPreview.value = res.data
    })
})
</script>

<template>
    <form class="fixed bottom-0 w-full bg-white p-6 border-t-4 border-gray-100 space-y-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                <slot name="header">

                </slot>
            </div>

            <div class="my-3">
                <slot name="main" :markdownPreviewEnabled="markdownPreviewEnabled">

                </slot>
                <div v-if="markdownPreviewEnabled" v-html="bodyMarkdownPreview" class="h-48 bg-gray-100 rounded-lg px-3 py-2 overflow-y-scroll border border-gray-300 shadow-sm">

                </div>

                <div class="flex items-center justify-between mt-4">
                    <MarkdownShorcutToolbar for="body"></MarkdownShorcutToolbar>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input @click="markdownPreviewEnabled = !markdownPreviewEnabled"  type="checkbox" value="" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ markdownPreviewEnabled ? 'Disable' : 'Enable' }} markdown preview</span>
                    </label>

                </div>
            </div>

            <div class="flex space-x-2">
                <slot name="button">

                </slot>
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>
