<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    queries: Array
})
</script>

<template>
    <div class="py-12">
        <div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <nav class="mt-3 space-y-2">
                        <ul class="flex flex-col space-y-2">
                            <Link  :class="{'font-semibold':!Object.keys(queries).length || (Object.keys(queries).length == 1 && queries.page)}" :href="route('home')"> All Discussion </Link>
                            <Link :class="{'font-semibold':queries.no_reply}" :href="route('home', {'no_reply': 1})"> No replies </Link>
                    </ul>
                </nav>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
