<template>
  <container>
    <div class="bg-white rounded-md shadow-md px-4 py-4">
      <div class="mb-4 text-2xl font-medium text-gray-700">Last Activities</div>
      <loader v-if="loading"> Statistics loading... </loader>
      <div v-else>
        <table class="min-w-full table-auto">
          <thead class="justify-between">
            <tr class="bg-gray-700">
              <th
                class="px-4 py-2 font-medium text-left"
                v-for="head in ['Type', 'Id', 'Action', 'Message', 'Date']"
                :key="head"
              >
                <span class="text-gray-100">{{ head }}</span>
              </th>
            </tr>
          </thead>
          <tbody class="rounded-md shadow-md">
            <tr
              class="border-b-2 border-gray-200"
              v-for="data in tableData"
              :key="data.id"
            >
              <td
                class="px-4 py-2 text-gray-700"
                :key="key"
                v-for="key in [
                  'trackable_type',
                  'trackable_id',
                  'action',
                  'message',
                  'created_at',
                ]"
              >
                {{ data[key] }}
              </td>
            </tr>
          </tbody>
        </table>
        <div class="mt-4 flex justify-end">
          <button
            v-for="link in paginationLinks"
            class="bg-gray-700 text-sm text-white ml-1 px-3 py-1 rounded-md focus:outline-none"
            :key="link.label"
            @click="fetch(link.url)"
            :disabled="link.active"
            :class="
              link.active || link.url == null
                ? 'opacity-50 cursor-default'
                : 'opactiy-100'
            "
            v-html="link.label"
          ></button>
        </div>
      </div>
    </div>
  </container>
</template>

<script>
import { ref } from "vue"
import Container from "../components/Container.vue"
import axios from "axios"
export default {
  components: { Container },
  name: "LastActivities",
  setup() {
    let loading = ref(true)
    let tableData = ref([])
    let paginationLinks = ref({})
    loading.value = true // loading only initialize...

    async function fetch(url) {
      if (url == null) return
      const response = await axios.get(url)
      const data = response.data
      paginationLinks.value = data.links
      tableData.value = data.data
      console.log(response)

      loading.value = false
    }

    fetch(window.tracker.lastActivities)
    return { paginationLinks, tableData, loading, fetch }
  },
}
</script>

<style>
</style>