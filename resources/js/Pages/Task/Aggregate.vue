<script setup>
import PageTitle from "@/Components/PageTitle.vue";
import { splitTargetTimeIntoHoursAndMinutes } from "@/Composable/util.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useAggregateStore } from "@/stores/aggregate.js";
import { Head } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const aggregateStore = useAggregateStore();
const { searchAggregate, getAggregate } = aggregateStore;

const aggregate = ref(getAggregate);
const hours = ref(0);
const minutes = ref(0);

watch(
  () => aggregateStore,
  (newAggregate, _) => {
    aggregate.value = newAggregate.getAggregate;

    const [h, m] = splitTargetTimeIntoHoursAndMinutes(
      Number(newAggregate.aggregate.total_timer_seconds)
    );
    hours.value = h;
    minutes.value = m;
  },
  { deep: true }
);

const fetchAggregate = async () => {
  await searchAggregate();
};
</script>

<template>
  <Head title="Task Aggregate" />
  <AuthenticatedLayout>
    <PageTitle value="集計ページ" />
    <div class="space-y-3">
      <div>
        <button
          type="button"
          class="min-w-12 text-sm font-semibold bg-blue-700 text-white rounded-full px-2 md:px-4 py-1 md:py-2"
          @click="fetchAggregate"
        >
          実行
        </button>
        <div v-if="aggregate?.total_tasks">
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
          <div>
            <div class="mb-2">今月実行したタスクの合計時間</div>
            <div class="border border-black w-40 text-center">
              {{ hours }} 時間 {{ minutes }} 分
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
