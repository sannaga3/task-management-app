<script setup>
import PageTitle from "@/Components/PageTitle.vue";
import { splitTargetTimeIntoHoursAndMinutes } from "@/Composable/util.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
  aggregate: Object,
});

const [hours, minutes] = splitTargetTimeIntoHoursAndMinutes(
  Number(props.aggregate.total_timer_seconds)
);
</script>

<template>
  <Head title="Task Aggregate" />
  <AuthenticatedLayout>
    <PageTitle value="集計ページ" />
    <div class="space-y-3">
      <div>
        <div class="mb-2">今月作成したタスクのステータス一覧</div>
        <div class="border border-black w-40">
          <div class="flex space-x-3 border-b border-black">
            <div class="w-24">タスク合計:</div>
            <div class="w-16 border-l border-black text-center">
              {{ aggregate.total_tasks }}
            </div>
          </div>
          <div class="flex space-x-3 border-b border-black">
            <div class="w-24">完了:</div>
            <div class="w-16 border-l border-black text-center">
              {{ aggregate.completed_tasks }}
            </div>
          </div>
          <div class="flex space-x-3 border-b border-black">
            <div class="w-24">進行中:</div>
            <div class="w-16 border-l border-black text-center">
              {{ aggregate.in_progress_tasks }}
            </div>
          </div>
          <div class="flex space-x-3">
            <div class="w-24">未着手:</div>
            <div class="w-16 border-l border-black text-center">
              {{ aggregate.not_started_tasks }}
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="mb-2">今月実行したタスクの合計時間</div>
        <div class="border border-black w-40 text-center">
          {{ hours }} 時間 {{ minutes }} 分
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
