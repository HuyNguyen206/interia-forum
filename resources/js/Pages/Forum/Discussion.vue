<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    discussion: Object,
    posts: Object
})

</script>

<template>
    <Link :href="route('discussions.show', discussion)" class="block p-6 mt-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex items-start">
            <div class="flex-grow">
                <div class="flex items-center space-x-4">

                    <div class="rounded-lg px-2 py-0.5 bg-gray-200 text-gray-700 text-sm">
                        {{discussion.topic.name}}
                    </div>
                    <span class="font-semibold">
                          <template v-if="discussion.is_pinned">
                        Pinned
                    </template>
                         {{discussion.title}}
                    </span>

                </div>


            </div>
            <div class="">
                {{discussion.user.username}}
            </div>

        </div>

    </Link>
</template>
