<template>
  <table>
    <thead>
      <tr>
        <th>Request ID</th>
        <th>Trackable Type</th>
        <th>Trackable ID</th>
        <th>Trackable Action</th>
        <th>Trackable Message</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="row in data" :key="row.id">
        <td>{{ row.id }}</td>
      </tr>
    </tbody>
  </table>
</template> 

<script>
import { reactive, ref } from "vue"
import axios from "axios"
export default {
  setup() {
    let loading = ref(true)
    let data = ref([])
    axios
      .get(window.tracker.activityStatistics)
      .then((resp) => {
        console.log(resp)
        data.value = resp.data.data
      })
      .catch((err) => {
        console.log(err)
      })
    return { data }
  },
}
</script>

<style>
</style>