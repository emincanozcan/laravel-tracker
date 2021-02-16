<template>
  <container>
    <div class="bg-white rounded-md shadow-md px-4 py-4">
      <div class="mb-4 text-2xl font-medium text-gray-700">Last Activities</div>
      <div class="my-4">
        <label class="text-gray-700">
          Action:
          <Select v-model="filters.action">
            <option value="">All</option>
            <option :value="v" v-for="v in filterOptions.action" :key="v">
              {{ v }}
            </option>
          </Select>
        </label>

        <label class="ml-6 text-gray-700">
          Type:
          <Select v-model="filters.trackableType">
            <option value="">All</option>
            <option :value="v" v-for="v in filterOptions.types" :key="v">
              {{ v }}
            </option>
          </Select>
        </label>
      </div>
      <loader v-if="loading"> Last Activities Are Loading... </loader>
      <div v-else>
        <table
          class="min-w-full table-auto rounded-md shadow-md overflow-hidden"
        >
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
          <tbody>
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
            class="bg-gray-700 text-sm text-white ml-1 px-2 py-1 rounded-md focus:outline-none"
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
import { ref, watch } from "vue"
import queryString from "query-string"
import Container from "../components/Container"
import axios from "axios"
import Select from "../components/Select"
import Loader from "../components/Loader"
export default {
  components: { Container, Select, Loader },
  name: "LastActivities",
  setup() {
    let loading = ref(true)
    let tableData = ref([])
    let paginationLinks = ref({})
    let filterOptions = ref({})
    let filters = ref({
      trackableType: "",
      trackableId: "",
      action: "",
    })

    watch(filters.value, () => fetch(window.tracker.lastActivities))

    async function fetch(url) {
      loading.value = true
      if (url == null) return
      const urlWithFilters = queryString.stringifyUrl({
        url,
        query: filters.value,
      })
      const response = await axios.get(urlWithFilters)
      const data = response.data

      if (data.links) {
        paginationLinks.value = data.links
      }

      tableData.value = data.data
      loading.value = false
    }

    async function fetchFilters() {
      const response = await axios.get(window.tracker.filters)
      filterOptions.value = response.data
    }

    fetch(window.tracker.lastActivities)
    fetchFilters()
    return {
      paginationLinks,
      tableData,
      loading,
      filters,
      filterOptions,
      fetch,
    }
  },
}
</script>

<style>
</style>