<script setup>
import {Link, router} from "@inertiajs/vue3";

const props = defineProps({
    discussion: Object
})

const deleteDiscussion = () => {
    if (!confirm('Are you sure to delete this discussion?')) {
        return;
    }

    router.delete(route('discussions.destroy', props.discussion), {
        preserveScroll: true
    })
}

</script>

<template>
    <Link :href="route('discussions.show', {discussion, 'page': discussion.last_page_post})"
          class="block p-6 mt-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex justify-between ">
            <div class="flex items-center space-x-4 w-10/12">

                <div class="rounded-lg px-2 py-0.5 bg-gray-200 text-gray-700 text-sm">
                    <p>
                        {{ discussion.topic.name }}
                    </p>
                </div>
                <div class="font-semibold">
                    <template v-if="discussion.is_pinned">
                        [Pinned]
                    </template>
                    <div class="flex space-x-2 items-center">
                        <p>
                            {{ discussion.title }}
                        </p>
                        <button v-if="discussion.can.delete" @click.prevent="deleteDiscussion" class="text-red-500 text-sm">Delete</button>
                    </div>
                    <p class="text-gray-400 text-sm mt-2 line-clamp-2">
                        {{ discussion.post.body_preview }}
                    </p>

                </div>

            </div>

            <div class="2/12">
                <p class="text-sm">
                    {{ discussion.user.username }}
                </p>
                <div class="flex space-x-2">
                    <div class="flex -space-x-2">
                        <img :title="participant.username" :key="participant.id"
                             v-for="participant in discussion.participants" :src="participant.avatar"
                             :alt="participant.username"
                             class="first-of-type:w-8 first-of-type:h-8 w-6 h-6 rounded-full ring-2 ring-white">
                    </div>
                    <tempplate v-if="discussion.has_more_participant">
                        <div>
                            + {{ discussion.remain_participant_count }}
                        </div>
                    </tempplate>
                </div>

            </div>
        </div>
        <div class="flex justify-between">
            <div>
                <template v-if="discussion.latest_post">
                    <Link :class="{'text-red-300': !discussion.latest_post.user}"
                          class="inline-block text-gray-400 text-sm" :href="route('discussions.show', discussion)">
                        Latest post by {{ discussion.latest_post.user?.username || '[Deleted user]' }}
                        <time>{{ discussion.latest_post.created_at }}</time>
                    </Link>
                </template>
            </div>

            <span class="inline-block text-sm">
                {{ discussion.posts_count }}
            </span>
        </div>


    </Link>
</template>
