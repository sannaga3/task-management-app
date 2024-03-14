<script setup>
import ErrorMessages from "@/Components/ErrorMessages.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Select from "@/Components/Select.vue";
import TextInput from "@/Components/TextInput.vue";
import { publishedMap, statusMap } from "@/Composable/Task/constants";
import useSelectChange from "@/Composable/useSelectChange";
import { router } from "@inertiajs/vue3";
import dayjs from "dayjs";
import { reactive } from "vue";

const props = defineProps({
  errors: Object,
  task: {
    type: Object,
    default: null,
  },
});

const defaultStatus = props?.task ? props.task.status.toString() : "0";
const defaultPublished = props?.task ? props.task.published.toString() : "0";

const [selectedStatus, handleChangeStatus] = useSelectChange(defaultStatus);
const [selectedPublished, handleChangePublished] =
  useSelectChange(defaultPublished);

const form = props?.task
  ? reactive({
      title: props.task.title,
      content: props.task?.content || null,
      begin: props.task.begin,
      end: props.task?.end || null,
      status: selectedStatus,
      published: selectedPublished,
      remarks: props.task?.remarks || null,
    })
  : reactive({
      title: null,
      content: null,
      begin: dayjs().format("YYYY-MM-DD"),
      end: null,
      status: selectedStatus,
      published: selectedPublished,
      remarks: null,
    });

function submit() {
  props?.task
    ? router.put(`/tasks/${props.task.id}`, form)
    : router.post("/tasks", form);
}

const inputStyle =
  "w-full bg-white bg-opacity-50 rounded border focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 transition-colors duration-200 ease-in-out";
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
                <div class="relative space-y-3">
                  <div v-if="task" class="text-md text-gray-700 font-semibold">
                    ID : {{ task.id }}
                  </div>
                  <div>
                    <InputLabel
                      for="title"
                      class="pb-1 text-sm text-gray-600"
                      value="タイトル"
                    />
                    <TextInput v-model="form.title" :class="inputStyle" />
                  </div>

                  <div>
                    <InputLabel
                      for="content"
                      class="pb-1 text-sm text-gray-600"
                      value="内容"
                    />
                    <textarea v-model="form.content" :class="inputStyle" />
                  </div>

                  <div class="flex space-x-5">
                    <div>
                      <InputLabel
                        for="begin"
                        class="pb-1 text-sm text-gray-600"
                        value="開始日"
                      />
                      <input
                        type="date"
                        v-model="form.begin"
                        required
                        :class="inputStyle"
                      />
                    </div>
                    <div class="flex items-end pb-1">~</div>
                    <div>
                      <InputLabel
                        for="end"
                        class="pb-1 text-sm text-gray-600"
                        value="終了日"
                      />
                      <input
                        type="date"
                        v-model="form.end"
                        :class="inputStyle"
                      />
                    </div>
                  </div>

                  <div class="flex space-x-5">
                    <div>
                      <InputLabel
                        for="published"
                        class="pb-1 text-sm text-gray-600"
                        value="ステータス"
                      />
                      <Select
                        :selected="selectedPublished"
                        :selectItems="statusMap"
                        :handleChange="handleChangeStatus"
                        id="status"
                        class="border rounded-lg h-8 text-xs"
                      />
                    </div>

                    <div>
                      <InputLabel
                        for="status"
                        class="pb-1 text-sm text-gray-600"
                        value="公開/非公開"
                      />
                      <Select
                        :selected="selectedPublished"
                        :selectItems="publishedMap"
                        :handleChange="handleChangePublished"
                        id="published"
                        class="border rounded-lg h-8 text-xs"
                      />
                    </div>
                  </div>

                  <div>
                    <InputLabel
                      for="remarks"
                      class="pb-1 text-sm text-gray-600"
                      value="備考"
                    />
                    <textarea v-model="form.remarks" :class="inputStyle" />
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
