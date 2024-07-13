<script setup>
import Modal from "@/Components/Modal.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import PerPageSelector from "@/Components/Pagination/PerPageSelector.vue";
import TimerCreateForm from "@/Components/Timer/TimerCreateForm.vue";
import TimerEditForm from "@/Components/Timer/TimerEditForm.vue";
import usePaginator from "@/Composable/Pagination/usePaginator.js";
import { splitTargetTimeIntoHoursAndMinutes } from "@/Composable/util.js";
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
  timers: Array,
  task: Object,
  meta: Object,
  total_time: Number,
});

const [targetHours, targetMinutes] = splitTargetTimeIntoHoursAndMinutes(
  props.task.target_time
);

const [totalHours, totalMinutes] = splitTargetTimeIntoHoursAndMinutes(
  props.total_time
);

const [refTimers, refMeta, refDisplayPageNumbers, updatePaginator] =
  usePaginator(props.timers, props.meta);

watch(
  () => props.timers,
  (newTimers, _) => {
    updatePaginator(newTimers, props.meta);
  },
  { deep: true }
);

const isOpenModal = ref(false);
const selectedTimer = ref(null);

const handleOpenModal = (timer = null) => {
  selectedTimer.value = timer;
  isOpenModal.value = true;
};

const handleCloseModal = () => {
  selectedTimer.value = null;
  isOpenModal.value = false;
};

const handleDelete = (id) => {
  router.delete(`/timers/${id}`, {
    onBefore: () => confirm("本当にタスクを削除しますか？"),
  });
};

const getTimerList = async (perPage, page) => {
  const res = await fetch(
    `/api/timers?task_id=${props.task.id}&per_page=${perPage}&page=${page}`
  );
  const data = await res.json();
  updatePaginator(data.timers, data.meta);
};
</script>

<template>
  <h3 class="text-lg text-center font-semibold">タスク実行履歴</h3>

  <div class="lg:w-3/4 w-full mx-auto overflow-auto mb-5">
    <div class="flex justify-between mb-3 mt-2">
      <div class="flex border-b border-gray-900 space-x-5 mt-4">
        <div class="flex px-2 space-x-3">
          <div>目標時間 :</div>
          <div>{{ targetHours }} 時間 {{ targetMinutes }} 分</div>
        </div>
        <div class="flex px-2 space-x-3">
          <div>実行済 :</div>
          <div>{{ totalHours }} 時間 {{ totalMinutes }} 分</div>
        </div>
        <div class="flex px-2 space-x-3">
          <div>達成率 :</div>
          <div>{{ Math.floor((total_time / task.target_time) * 100) }} %</div>
        </div>
      </div>
      <button
        v-if="task.status === 1"
        @click="handleOpenModal()"
        class="text-sm px-4 py-1 font-semibold bg-indigo-500 text-white rounded-full"
      >
        タスク実行
      </button>
    </div>
    <div class="flex justify-between items-end pb-2">
      <Pagination
        :refMeta="refMeta"
        :refDisplayPageNumbers="refDisplayPageNumbers"
        :fetchPageData="getTimerList"
      />
      <PerPageSelector :refMeta="refMeta" :fetchPageData="getTimerList" />
    </div>
    <table class="table-auto w-full text-left whitespace-no-wrap mb-5">
      <thead>
        <tr>
          <th class="table-header-style">ID</th>
          <th class="table-header-style">開始時刻</th>
          <th class="table-header-style">終了時刻</th>
          <th class="table-header-style">編集</th>
          <th class="table-header-style">削除</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="timer in refTimers"
          :key="timer.id"
          class="border-b-2 border-gray-300"
        >
          <td class="table-body-style">{{ timer.id }}</td>
          <td class="table-body-style">{{ timer.start_time }}</td>
          <td class="table-body-style">{{ timer.end_time }}</td>
          <td>
            <button
              type="button"
              v-if="task.status === 1"
              @click="handleOpenModal(timer)"
              class="text-sm px-4 py-1 font-semibold bg-orange-500 text-white rounded-full"
            >
              編集
            </button>
          </td>
          <td>
            <button
              v-if="task.status === 1"
              type="button"
              @click="handleDelete(timer.id)"
              class="text-sm px-4 py-1 font-semibold bg-red-500 text-white rounded-full"
            >
              削除
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <Modal :show="isOpenModal" @close="isOpenModal = false">
      <div class="p-2 relative space-y-2 mt-2">
        <h2 class="text-center text-2xl font-bold">
          {{ selectedTimer ? "タイマー履歴編集" : "タイマー計測" }}
        </h2>
        <TimerEditForm
          v-if="selectedTimer !== null"
          :task="task"
          :timer="selectedTimer"
          :closeModal="handleCloseModal"
        />
        <TimerCreateForm
          v-if="selectedTimer === null"
          :task="task"
          :timer="selectedTimer"
          :closeModal="handleCloseModal"
        />
        <button
          @click="handleCloseModal()"
          class="absolute top-2 right-3 bg-red-500 rounded-full text-sm text-white px-2 pb-0.5 font-bold"
        >
          x
        </button>
      </div>
    </Modal>
  </div>
</template>
@/Composable/Pagination/usePaginator.js
