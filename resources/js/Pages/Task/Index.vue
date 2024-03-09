<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import PageTitle from "@/Components/PageTitle.vue";
import Pagination from "@/Components/Pagination.vue";
import PerPageSelector from "@/Components/PerPageSelector.vue";
import { convertPublished, convertStatus } from "@/Composable/Task//modules";
import usePaginator from "@/Composable/usePaginator.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    tasks: Array,
    meta: Object,
    auth: Object,
});

const [refTasks, refMeta, refDisplayPageNumbers, updatePaginator] =
    usePaginator(props.tasks, props.meta);

const getNewTasks = async (perPage, page) => {
    const res = await fetch(
        `/api/searchTaskList?per_page=${perPage}&page=${page}`
    );
    const data = await res.json();
    updatePaginator(data.tasks, data.meta);
};
</script>

<template>
    <Head title="TaskList" />
    <AuthenticatedLayout>
        <FlashMessage />
        <PageTitle value="タスク一覧" />
        <div class="lg:w-3/4 w-full mx-auto overflow-auto mb-5">
            <div class="flex justify-between items-end pb-2">
                <Pagination
                    :refMeta="refMeta"
                    :refDisplayPageNumbers="refDisplayPageNumbers"
                    :fetchNewData="getNewTasks"
                />
                <PerPageSelector :refMeta="refMeta" :getNewData="getNewTasks" />
            </div>
            <table class="table-auto w-full text-left whitespace-no-wrap mb-5">
                <thead>
                    <tr>
                        <th class="table-header-style">ID</th>
                        <th class="table-header-style">ユーザー名</th>
                        <th class="table-header-style">タイトル</th>
                        <th class="table-header-style">開始日</th>
                        <th class="table-header-style">ステータス</th>
                        <th class="table-header-style">公開/非公開</th>
                        <th class="table-header-style">詳細</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="task in refTasks"
                        :key="task.id"
                        class="border-b-2 border-gray-300"
                    >
                        <td class="table-body-style">{{ task.id }}</td>
                        <td class="table-body-style">
                            {{ task.user.name }}
                        </td>
                        <td class="table-body-style">{{ task.title }}</td>
                        <td class="table-body-style">{{ task.begin }}</td>
                        <td class="table-body-style">
                            {{ convertStatus(task.status) }}
                        </td>
                        <td class="table-body-style">
                            {{ convertPublished(task.published) }}
                        </td>
                        <td>
                            <Link
                                v-if="auth.user.id === task.user_id"
                                :href="
                                    route('tasks.show', {
                                        id: task.id,
                                    })
                                "
                                class="min-w-12 text-sm font-semibold bg-blue-700 text-white rounded-full px-2 md:px-4 py-1 md:py-2"
                                >詳細</Link
                            >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
