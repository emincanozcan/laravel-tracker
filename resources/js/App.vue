<template>
  <tracker-header class="mb-8" />
  <router-view />
</template>

<script>
import TrackerHeader from "./components/Header.vue"
export default {
  components: { TrackerHeader },
  name: "App",
}
</script>
<style scoped>
</style>

