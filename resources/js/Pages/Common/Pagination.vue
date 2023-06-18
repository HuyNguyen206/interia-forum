<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    links: Array
})

</script>

<template>
    <nav aria-label="Page navigation example" class="mt-3 mx-auto">
        <ul class="inline-flex -space-x-px">
            <li v-for="(link) in links" :key="link.label">
                <Link v-html="link.label" :href="link.url" :class="{'bg-gray-700 text-white' : link.active, 'pointer-events-none opacity-50': !link.url}" class=" px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-600 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                </Link>
            </li>
        </ul>
    </nav>
</template>
