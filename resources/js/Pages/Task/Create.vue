<script setup>
import PageTitle from "@/Components/PageTitle.vue";
import TaskForm from "@/Components/Task/TaskForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <Head title="Task Create" />
  <AuthenticatedLayout>
    <PageTitle value="商品登録" />
    <TaskForm />
  </AuthenticatedLayout>
</template>
