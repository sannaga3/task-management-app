<script setup>
import ErrorMessages from "@/Components/ErrorMessages.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { router } from "@inertiajs/vue3";
import { reactive, ref, watch } from "vue";

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
  start_time: props.timer.start_time,
  end_time: props.timer.end_time,
  task_id: props.timer.task_id,
  meta: props.meta,
});

const refStartDate = ref(props.timer.start_time.slice(0, 10));
const refStartTime = ref(props.timer.start_time.slice(11, 19));
const refEndDate = ref(props.timer.end_time.slice(0, 10));
const refEndTime = ref(props.timer.end_time.slice(11, 19));

watch(
  () => [refStartDate, refStartTime],
  ([newDate, newTime], _) => {
    form.start_time = `${newDate.value} ${newTime.value}`;
  },
  { deep: true }
);

watch(
  () => [refEndDate, refEndTime],
  ([newDate, newTime], _) => {
    form.end_time = `${newDate.value} ${newTime.value}`;
  },
  { deep: true }
);

const submit = () => {
  props.closeModal();
  router.put(`/timers/${props.timer.id}`, form);
};
const inputStyle =
  "bg-white bg-opacity-50 rounded border focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 transition-colors duration-200 ease-in-out";
</script>

<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="overflow-hidden shadow-sm sm:rounded-lg">
      <div class="container px-5 mx-auto">
        <form @submit.prevent="submit">
          <div class="lg:w-1/2 md:w-2/3 mx-auto">
            <div class="flex flex-wrap -m-2">
              <div class="p-2 w-full">
                <div class="flex justify-start mb-3">
                  <ErrorMessages :errors="errors" />
                </div>
                <div class="relative space-y-2">
                  <div v-if="timer" class="text-md text-gray-700 font-semibold">
                    ID : {{ timer.id }}
                  </div>

                  <div>
                    <InputLabel
                      for="start_time"
                      class="pb-1 text-sm text-gray-600"
                      value="開始時刻"
                    />
                    <div class="flex space-x-2 h-10">
                      <input
                        type="date"
                        id="start_date"
                        v-model="refStartDate"
                        required
                        :class="inputStyle"
                      />
                      <input
                        type="time"
                        step="1"
                        id="start_time"
                        v-model="refStartTime"
                        required
                        :class="inputStyle"
                        class="w-36"
                      />
                    </div>
                  </div>

                  <div>
                    <InputLabel
                      for="start_time"
                      class="pb-1 text-sm text-gray-600"
                      value="終了時刻"
                    />
                    <div class="flex space-x-2 h-10">
                      <input
                        type="date"
                        id="start_date"
                        v-model="refEndDate"
                        required
                        :class="inputStyle"
                      />
                      <input
                        type="time"
                        step="1"
                        id="start_time"
                        v-model="refEndTime"
                        required
                        :class="inputStyle"
                        class="w-36"
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="p-4 w-full">
                <button
                  type="submit"
                  class="flex mx-auto text-white bg-indigo-500 py-1.5 px-6 hover:bg-indigo-600 rounded-full"
                >
                  送信
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
