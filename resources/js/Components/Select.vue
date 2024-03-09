<script setup>
import { ref } from "vue";

const props = defineProps({
  selectItems: Object,
  id: String,
  selected: String,
  handleChange: Function,
  parentClassProps: {
    type: String,
    default: "border rounded-lg h-8 text-xs",
  },
  childClassProps: {
    type: String,
    default: "",
  },
});

const selected = ref(props.selected);

const changeSelected = (e) => {
  props.handleChange(e.target.value);
};
</script>

<template>
  <select
    :modelValue="selected"
    :id="id"
    :class="parentClassProps"
    @change="changeSelected"
  >
    <option v-for="(label, value) in selectItems" :key="value" :value="value">
      <span :class="childClassProps">{{ label }}</span>
    </option>
  </select>
</template>
