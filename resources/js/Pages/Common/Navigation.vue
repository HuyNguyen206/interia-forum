<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    queries: Array
})
</script>

<template>
        <div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900">
                    <nav class="mt-3 space-y-2">
                        <ul class="flex flex-col space-y-2">
                            <Link  :class="{'font-semibold':!Object.keys(queries).length || (Object.keys(queries).length == 1 && queries.page)}" :href="route('home')"> All Discussion </Link>
                            <Link :class="{'font-semibold':queries.no_reply}" :href="route('home', {'no_reply': 1})"> No replies </Link>
                            <Link :class="{'font-semibold':queries.solved == 1}" :href="route('home', {'solved': 1})"> Solved </Link>
                            <Link :class="{'font-semibold':queries.solved == 0}" :href="route('home', {'solved': 0})"> Unsolved </Link>
                            <Link :class="{'font-semibold':queries.mentioned == 1}" :href="route('home', {'mentioned': 1})"> Mentioned </Link>
                    </ul>

                        <ul class="flex flex-col space-y-2 border-t border-t-gray-200 mt-2 pt-2" v-if="$page.props.auth.user">
                            <Link  :class="{'font-semibold':queries.my_discussion}" :href="route('home', {'my_discussion': 1})"> My Discussion </Link>
                            <Link :class="{'font-semibold':queries.is_participant}" :href="route('home', {'is_participant': 1})">My replies </Link>
                    </ul>
                </nav>
                </div>

            </div>
        </div>
</template>

<style scoped>

</style>
