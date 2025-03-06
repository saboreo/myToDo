<script setup>
defineProps({
  title: String,
  count: Number
});
</script>

<template>
    <div>
        <div class="relative overflow-hidden rounded-lg px-4 py-5 border shadow-sm md:p-6">
          <dt class="truncate text-lg font-medium text-gray-500 dark:text-gray-400">{{ title }}</dt>
          <dd class="mt-1 text-6xl font-semibold tracking-tight text-gray-900 dark:text-gray-200">{{ count }}</dd>
        </div>
    </div>
  </template>