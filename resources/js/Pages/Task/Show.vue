<script setup>
import FlashMessage from "@/Components/FlashMessage.vue";
import PageTitle from "@/Components/PageTitle.vue";
import TimerList from "@/Components/Timer/TimerList.vue";
import { convertPublished, convertStatus } from "@/Composable/Task/modules";
import { nl2br } from "@/Composable/util";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";

const props = defineProps({
  timers: Object,
  task: Object,
  meta: Object,
  total_time: Number,
});

const rowStyle =
  "w-full flex min-h-8 border-b border-gray-600 px-4 md:px-8 lg:px-12 space-x-5 pb-1";
const containerStyle = "min-w-32";

const handleDelete = (id) => {
  router.delete(`/tasks/${id}`, {
    onBefore: () => confirm("本当にタスクを削除しますか？"),
  });
};
</script>

<template>
  <Head title="Task Show" />
  <AuthenticatedLayout>
    <FlashMessage />
    <PageTitle value="タスク詳細" />
    <div class="flex flex-col lg:w-2/3 w-full mx-auto overflow-x-auto mb-5">
      <div class="flex justify-end space-x-5 mr-10">
        <Link
          :href="
            route('tasks.edit', {
              id: task.id,
            })
          "
          class="text-sm px-4 py-2 font-semibold bg-orange-500 text-white rounded-full"
          >編集</Link
        >
        <button
          type="button"
          @click="handleDelete(task.id)"
          class="text-sm px-4 py-2 font-semibold bg-red-500 text-white rounded-full"
        >
          削除
        </button>
      </div>
      <div class="w-full flex justify-center text-left whitespace-nowrap mt-8">
        <div>
          <div class="flex flex-col space-y-5">
            <div :class="rowStyle">
              <div :class="containerStyle">ID</div>
              <div :class="containerStyle">{{ task.id }}</div>
            </div>
            <div :class="rowStyle">
              <div :class="containerStyle">ユーザー名</div>
              <div :class="containerStyle">{{ task.user.name }}</div>
            </div>
            <div :class="rowStyle">
              <div :class="containerStyle">タイトル</div>
              <div :class="containerStyle">{{ task.title }}</div>
            </div>
            <div :class="rowStyle">
              <div :class="containerStyle">内容</div>
              <div
                v-html="nl2br(task?.content || null)"
                :class="containerStyle"
              ></div>
            </div>
            <div :class="rowStyle">
              <div :class="containerStyle">開始日</div>
              <div :class="containerStyle">{{ task.begin }}</div>
            </div>
            <div :class="rowStyle">
              <div :class="containerStyle">終了日</div>
              <div :class="containerStyle">{{ task.end }}</div>
            </div>
            <div :class="rowStyle">
              <div :class="containerStyle">ステータス</div>
              <div :class="containerStyle">
                {{ convertStatus(task.status) }}
              </div>
            </div>
            <div :class="rowStyle">
              <div :class="containerStyle">公開/非公開</div>
              <div :class="containerStyle">
                {{ convertPublished(task.published) }}
              </div>
            </div>
            <div :class="rowStyle">
              <div :class="containerStyle">備考</div>
              <div
                v-html="nl2br(task?.remarks || null)"
                :class="containerStyle"
              ></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="p-5">
      <TimerList
        :timers="timers"
        :meta="meta"
        :task="task"
        :total_time="total_time"
      />
    </div>
  </AuthenticatedLayout>
</template>
