<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import NavLink from "@/Components/NavLink.vue";
</script>

<template>
  <div class="hidden sm:flex sm:items-center sm:ms-6">
    <div class="ms-3 relative">
      <Dropdown align="right" width="48">
        <template #trigger>
          <span class="inline-flex rounded-md">
            <button
              type="button"
              class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-800 hover:text-black focus:outline-none transition ease-in-out duration-150"
            >
              タスク管理
              <svg
                class="ms-2 -me-0.5 h-4 w-4"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </span>
        </template>

        <template #content>
          <div class="flex flex-col border-2 border-slate-300 rounded-sm">
            <NavLink
              :href="route('tasks.index')"
              :active="route().current('tasks.index')"
              class="inline-flex items-center px-4 pt-2 pb-1 border-b-2 border-indigo-500 text-md font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
            >
              タスク一覧
            </NavLink>
            <NavLink
              :href="route('tasks.create')"
              :active="route().current('tasks.create')"
              class="inline-flex items-center px-4 pt-2 pb-1 border-b-2 border-indigo-500 text-md font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
            >
              タスク作成
            </NavLink>
            <!-- <NavLink :href="route('logout')" method="post" as="button">
              <span class="text-lg">Log Out</span>
            </NavLink> -->
          </div>
        </template>
      </Dropdown>
    </div>
  </div>
</template>
