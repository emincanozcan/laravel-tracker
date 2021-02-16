<template>
  <container>
    <div class="mb-8 flex items-center justify-between">
      <label>
        <span>Show statistics for last</span>
        <input
          type="number"
          class="mx-2 rounded-md px-2 py-2 w-20 border-gray-200"
          v-model="days"
        />
        <span>days.</span>
      </label>
      <button
        @click="fetch"
        class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer"
      >
        Reload Statistics
      </button>
    </div>
    <loader v-if="loading"> Statistics loading... </loader>
    <div v-else>
      <statistic-area title="General Statistics">
        <statistic-box
          class="bg-green-500 text-white"
          :count="data.total_count"
          title="Total Count Of Total Activities"
        />
      </statistic-area>

      <statistic-area title="Count By Actions">
        <statistic-box
          v-for="act in data.count_by_action"
          :key="act.action"
          class="bg-blue-500 text-white"
          :count="act.action_count"
          :title="`Total Count Of '${act.action}'`"
        />
      </statistic-area>

      <statistic-area title="Count By Trackables">
        <statistic-box
          v-for="typeData in data.count_by_trackable_types"
          :key="typeData.trackable_type"
          class="bg-indigo-500 text-white"
          :count="typeData.trackable_type_count"
          :title="`Total Count Of '${typeData.trackable_type}'`"
        />
      </statistic-area>
    </div>
  </container>
</template>
 
<script>
import { ref } from "vue"
import axios from "axios"
import StatisticBox from "./../components/StatisticBox.vue"
import Container from "./../components/Container.vue"
import StatisticArea from "../components/StatisticArea.vue"
export default {
  components: { StatisticBox, Container, StatisticArea },
  name: "Statistics",
  setup() {
    let loading = ref(true)
    let data = ref([])
    let days = ref(7)
    async function fetch() {
      loading.value = true
      const response = await axios.get(
        window.tracker.activityStatistics + `?days=${days.value}`
      )
      data.value = response.data
      loading.value = false
    }
    fetch()
    return { data, days, loading, fetch }
  },
}
</script>

<style>
</style>