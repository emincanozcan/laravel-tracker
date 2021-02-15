<template>
  <tracker-header />
  <statistics />
  <last-activities />
</template>

<script>
import TrackerHeader from "./components/Header.vue"
import LastActivities from "./components/LastActivities.vue"
import Statistics from "./components/Statistics.vue"
export default {
  components: { TrackerHeader, LastActivities, Statistics },
  name: "App",
}
</script>

<style scoped>
</style>

