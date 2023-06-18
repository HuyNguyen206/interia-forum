<script setup>

defineProps({
    post: Object
})

</script>

<template>
        <div class="flex items-start">
            <div class="flex-grow">
                <div class="flex items-center space-x-4">

                    <div class="rounded-lg px-2 py-0.5 bg-gray-200 text-gray-700 text-sm">
                        {{post.body}}
                    </div>
                </div>
            </div>
        </div>
</template>
