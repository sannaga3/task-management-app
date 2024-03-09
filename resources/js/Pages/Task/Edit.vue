<script setup>
import PageTitle from "@/Components/PageTitle.vue";
import TaskForm from "@/Components/TaskForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  task: Object,
});
</script>

<template>
  <Head title="Task Edit" />
  <AuthenticatedLayout>
    <PageTitle value="商品編集" />
    <TaskForm :task="task" />
  </AuthenticatedLayout>
</template>
