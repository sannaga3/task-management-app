<script setup>
const props = defineProps({
  refMeta: {
    type: Object,
    required: true,
  },
  refDisplayPageNumbers: {
    type: Array,
    required: true,
  },
  fetchNewData: {
    type: Function,
    required: true,
  },
});

const changePage = async (nextPage) => {
  if (props.refMeta.current_page !== nextPage)
    await props.fetchNewData(props.refMeta.per_page, nextPage);
};
</script>

<template>
  <div class="flex justify-start items-center">
    <div class="space-x-2">
      <span>{{ refMeta.total }} 件中</span>
      <span>{{ refMeta.from }} ~ {{ refMeta.to }} 件</span>
    </div>
    <div class="space-x-2 ml-5 flex items-center">
      <button
        @click="changePage(refMeta.current_page - 1)"
        :disabled="refMeta.current_page === 1"
        class="h-7 bg-blue-500 rounded-l-xl text-xs text-white font-bold cursor-pointer px-2"
      >
        <span class="pl-1">前</span>
      </button>
      <div v-if="refDisplayPageNumbers[0] !== 1" class="font-bold">. . .</div>
      <div v-for="number in refDisplayPageNumbers">
        <button
          @click="changePage(number)"
          :class="{
            'bg-blue-700 text-white scale-110': refMeta.current_page === number,
            'bg-blue-500 text-white': refMeta.current_page !== number,
          }"
          class="h-10 w-8 rounded-full font-semibold px-2 py-0.5"
        >
          {{ number }}
        </button>
      </div>
      <div
        v-if="refDisplayPageNumbers[2] !== refMeta.last_page"
        class="font-bold"
      >
        . . .
      </div>
      <button
        @click="changePage(refMeta.current_page + 1)"
        :disabled="refMeta.current_page === refMeta.last_page"
        class="h-7 bg-blue-500 rounded-r-xl text-xs text-white font-bold cursor-pointer px-2"
      >
        <span class="pr-1">次</span>
      </button>
    </div>
  </div>
</template>
