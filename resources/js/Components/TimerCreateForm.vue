<script setup>
import { formatElapsedTime, formatToDateTimeJa } from "@/Composable/util.js";
import { router } from "@inertiajs/vue3";
import { onUnmounted, reactive, ref } from "vue";

const props = defineProps({
  errors: Object,
  task: {
    type: Object,
  },
  timer: {
    type: Object,
  },
  closeModal: {
    type: Function,
  },
});

const form = reactive({
  start_time: null,
  end_time: null,
  task_id: props.task.id,
});

const elapsedTime = ref(0);
let intervalId = null;

const startTimer = () => {
  const start_time = new Date();
  form.start_time = formatToDateTimeJa(start_time);

  intervalId = setInterval(() => {
    const currentTime = new Date();
    elapsedTime.value = currentTime - start_time;
  }, 1000);
};

onUnmounted(() => {
  if (intervalId) clearInterval(intervalId);
});

const stopTimer = () => {
  form.end_time = formatToDateTimeJa(new Date());
  clearInterval(intervalId);
  submit();
};

const submit = () => {
  props.closeModal();
  router.post("/timers", form);
};
</script>

<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="overflow-hidden shadow-sm sm:rounded-lg">
      <div class="container px-5 mx-auto">
        <form @submit.prevent="submit">
          <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
              <div class="p-2 w-full">
                <div class="flex justify-start mb-3"></div>
                <div class="relative space-y-3">
                  <div v-if="timer" class="text-md text-gray-700 font-semibold">
                    ID : {{ timer.id }}
                  </div>

                  <div>
                    <div for="end_time" class="pb-1 text-sm">開始時刻</div>
                    <div>
                      {{ form.start_time }}
                    </div>
                  </div>

                  <div>
                    <div v-if="form.end_time !== null || intervalId === null">
                      <div for="end_time" class="pb-1 text-sm">終了時刻</div>
                      {{ form.end_time }}
                    </div>
                    <div v-if="intervalId !== null && form.end_time === null">
                      <div for="end_time" class="pb-1 text-sm">計測中</div>
                      {{ formatElapsedTime(Math.floor(elapsedTime / 1000)) }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="p-4 w-full">
                <button
                  v-if="elapsedTime === 0"
                  type="button"
                  @click="startTimer"
                  class="flex mx-auto text-white bg-green-500 py-1.5 px-6 hover:bg-green-600 rounded-full"
                >
                  スタート
                </button>
                <button
                  v-if="elapsedTime !== 0"
                  type="button"
                  @click="stopTimer"
                  class="flex mx-auto text-white bg-red-500 py-1.5 px-6 hover:bg-red-600 rounded-full"
                >
                  ストップ
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
