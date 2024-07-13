<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import Select from "@/Components/Select.vue";
import { ref } from "vue";

const props = defineProps({
  refMeta: {
    type: Object,
    required: true,
  },
  fetchPageData: {
    type: Function,
    required: true,
  },
  perPageItems: {
    type: Array,
    default: ["10", "25", "50", "100"],
  },
});

const selectedPerPage = ref(props.perPageItems[0]);

const changePerPage = async (newPerPageIndex) => {
  const newPerPage = props.perPageItems[Number(newPerPageIndex)];

  if (props.refMeta.per_page !== newPerPage) {
    await props.fetchPageData(newPerPage, 1);
    selectedPerPage.value = newPerPage;
  }
};
</script>

<template>
  <div class="w-20 text-md">
    <InputLabel
      for="status"
      class="w-full h-6 bg-gray-700 text-white text-center text-sm font-semibold rounded-t-lg pt-1"
      value="表示数"
    />
    <Select
      :selected="selectedPerPage"
      :selectItems="perPageItems"
      :handleChange="changePerPage"
      parentClassProps="w-full bg-white h-7 text-sm py-0 text-center border-2 border-gray-700 rounded-b-lg focus:outline-none"
    />
  </div>
</template>
