<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Create from "@/Pages/Forum/Discussion/Create.vue";
import useCreateDiscussion from "@/Composables/useCreateDiscussion.js";
import useCreateReply from "@/Composables/useCreateReply.js";
import CreateReplyForm from "@/Pages/Forum/Discussion/CreateReplyForm.vue";

const {visible} = useCreateDiscussion()
const {visibleReply} = useCreateReply()
</script>

<template>
    <AuthenticatedLayout>
      <div class="max-w-7xl mx-auto grid grid-cols-7 px-6 gap-4 md:px-12">
          <div class="col-span-2">
              <slot name="side"/>
          </div>
          <div class="col-span-5">
             <slot/>
          </div>
      </div>
    </AuthenticatedLayout>
    <template v-if="visible">
        <Create></Create>
    </template>

    <template v-if="visibleReply">
        <CreateReplyForm></CreateReplyForm>
    </template>
</template>
