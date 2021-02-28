<template>
  <container>
    <loader v-if="loading"> Statistics loading... </loader>
    <div v-else>
      <statistic-area title="General Statistics">
        <statistic-box
          class="bg-green-500 text-white"
          :count="data.total_count"
          title="Total Count Of Statistics"
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
import Loader from "../components/Loader.vue"
export default {
  components: { StatisticBox, Container, StatisticArea, Loader },
  name: "Statistics",
  setup() {
    let loading = ref(true)
    let data = ref([])
    async function fetch() {
      loading.value = true
      const response = await axios.get(window.tracker.activityStatistics)
      data.value = response.data
      loading.value = false
    }
    fetch()
    return {
      data,
      loading,
      fetch,
    }
  },
}
</script>

<style>
</style>
