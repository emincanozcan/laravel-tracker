<template>
  <div>Ok!</div>
</template>

<script>
import { ref } from 'vue'
import axios from 'axios'
export default {
  name: "Statistics",
  setup() {
    let loading = ref(true)
    let data = ref([])

    async function fetch() {
      const response = await axios.get(window.tracker.activityStatistics)
      data.value = response.data
      loading.value = false
    }
    fetch()
    return { data }
  },
}
</script>

<style>
</style>