<script setup>

</script>

<template>
<div class="fixed bottom-0 w-full bg-white p-6 border-t-4 border-gray-100 space-y-3">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
            <slot name="header">

            </slot>
        </div>

        <div class="my-3">
            <slot name="main">

            </slot>
        </div>

        <div>
            <slot name="button">

            </slot>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
