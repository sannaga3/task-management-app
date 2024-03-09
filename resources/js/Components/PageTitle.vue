<script setup>
import { defineProps } from "vue";

const props = defineProps({
  value: String,
});
</script>

<template>
  <div class="flex flex-col text-center py-8">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ value }}
    </h1>
  </div>
</template>
