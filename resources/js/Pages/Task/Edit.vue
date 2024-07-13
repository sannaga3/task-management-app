<script setup>
import PageTitle from "@/Components/PageTitle.vue";
import TaskForm from "@/Components/Task/TaskForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  task: Object,
});
</script>

<template>
  <Head title="Task Edit" />
  <AuthenticatedLayout>
    <PageTitle value="タスク編集" />
    <TaskForm :task="task" />
  </AuthenticatedLayout>
</template>
