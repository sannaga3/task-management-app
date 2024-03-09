<script setup></script>

<template>
  <div class="mt-5">
    <div
      class="text-white font-bold bg-teal-400 py-2 pl-5 rounded-md"
      v-if="$page.props.flash.status === 'success'"
    >
      {{ $page.props.flash.message }}
    </div>
    <div
      class="text-white font-bold bg-red-400 py-2 pl-5 rounded-md"
      v-if="$page.props.flash.status === 'danger'"
    >
      {{ $page.props.flash.message }}
    </div>
  </div>
</template>
