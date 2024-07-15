<script setup>
import Modal from "@/Components/Modal.vue";
import PageTitle from "@/Components/PageTitle.vue";
import useModal from "@/Composable/Modal/useModal.js";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import apiClient from "@/lib.js";
import dayGridPlugin from "@fullcalendar/daygrid";
import FullCalendar from "@fullcalendar/vue3";
import { Head } from "@inertiajs/vue3";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { computed, onBeforeMount, ref, watch } from "vue";
import HistoryCard from "../../Components/Timer/HistoryCard.vue";

const histories = ref([]);
const events = ref([]);
const selectedMonth = ref({
  month: new Date().getMonth(),
  year: new Date().getFullYear(),
});
const calendarRef = ref(null);
const [isOpenModal, openModal, closeModal, modalItem] = useModal();

const getEvents = () => {
  const items = histories.value ? histories.value : [];

  return items.map((history, index) => {
    return {
      id: index,
      title: history.title,
      start: new Date(history.start_time),
      color: "blue",
    };
  });
};

const calendarOptions = computed(() => {
  return {
    plugins: [dayGridPlugin],
    initialView: "dayGridMonth",
    events: events.value,
    locale: "ja",
    displayEventTime: false,
    slotEventOverlap: false,
    timeZone: "Asia/Tokyo",
    eventClick: handleEventClick,
  };
});

const fetchHistories = async (year, month) => {
  month = month + 1;

  try {
    const data = await apiClient.get("/api/history", {
      params: { year, month },
    });

    histories.value = Array.isArray(data) ? data : [];
    events.value = getEvents();

    const calendarApi = calendarRef.value.getApi();
    calendarApi.gotoDate(new Date(year, month, 1));
  } catch (error) {
    console.log("Error : ", error);
  }
};

onBeforeMount(async () => {
  let { year, month } = selectedMonth.value;
  await fetchHistories(year, month);
});

watch(selectedMonth, async (newSelectedMonth) => {
  if (!newSelectedMonth) return;
  let { month, year } = newSelectedMonth;
  await fetchHistories(year, month);
});

const formatMonthAsNumber = (selectedMonth) => {
  const month = selectedMonth.month + 1;
  return String(month).padStart(2, "0");
};

const handleEventClick = (e) => {
  const newModalItem = histories.value[e.event.id];
  openModal(newModalItem);
};
</script>

<template>
  <Head title="Task History" />
  <AuthenticatedLayout>
    <PageTitle value="進捗履歴" />
    <div class="w-full px-5 pb-10 space-y-10">
      <div class="flex justify-center items-center space-x-5">
        <div>対象月 :</div>
        <div>
          <VueDatePicker
            v-model="selectedMonth"
            month-picker
            :format-month="formatMonthAsNumber"
            :max-date="new Date()"
          />
        </div>
      </div>
      <div class="mx-auto w-4/5">
        <div v-if="calendarOptions">
          <FullCalendar ref="calendarRef" :options="calendarOptions" />
        </div>
        <Modal :show="isOpenModal" @close="closeModal()">
          <div class="flex justify-end">
            <button
              @click="closeModal()"
              class="bg-red-500 rounded-full text-sm text-white px-2 pb-0.5 mr-2 mt-2 font-bold"
            >
              x
            </button>
          </div>
          <HistoryCard :history="modalItem" />
        </Modal>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
