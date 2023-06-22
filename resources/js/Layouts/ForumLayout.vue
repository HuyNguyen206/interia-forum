<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
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
</template>
