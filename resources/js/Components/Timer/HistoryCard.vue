<script setup>
import { defineProps } from "vue";
import { VCard, VListItem, VListItemTitle } from "vuetify/components";

const { history } = defineProps({
  history: Object,
});
</script>

<template>
  <v-card class="mx-auto" outlined>
    <div class="px-10 py-5">
      <v-list-item three-line>
        <div class="text-overline mb-4">タスクID: {{ history.task_id }}</div>
        <v-list-item-title class="text-h5 mb-1">
          タスク名 : {{ history.title }}
        </v-list-item-title>
        <v-list-item-subtitle>
          内容 : {{ history.content }}
        </v-list-item-subtitle>
        <v-list-item-subtitle>
          開始 : {{ history.start_time }}
        </v-list-item-subtitle>
        <v-list-item-subtitle>
          終了 : {{ history.end_time }}
        </v-list-item-subtitle>
      </v-list-item>

      <!-- <v-card-actions>
        <v-btn rounded size="small" variant="elevated" color="orange dark">
          <span class="text-white">編集</span>
        </v-btn>
      </v-card-actions> -->
    </div>
  </v-card>
</template>
