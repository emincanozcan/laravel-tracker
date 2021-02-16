<template>
  <header class="w-full bg-gray-800 py-4">
    <container class="flex items-center justify-between">
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-medium text-white tracking-wider">Tracker</h1>
      </div>
      <nav class="flex">
        <router-link
          to="/tracker"
          active-class="opacity-75"
          class="mr-8 text-white inline-block px-4 py-2 tracking-wider"
        >
          Home
        </router-link>
        <router-link
          to="/tracker/last-activities"
          class="mr-8 text-white inline-block px-4 py-2 tracking-wider"
          active-class="opacity-75"
        >
          Last Activities
        </router-link>
        <router-link
          to="/tracker/statistics"
          class="text-white inline-block px-4 py-2 tracking-wider"
          active-class="opacity-75"
        >
          Statistics
        </router-link>
      </nav>
    </container>
  </header>
</template>

<script>
import Container from "./Container.vue"

export default {
  components: { Container },
  name: "Header",
  setup() {},
}
</script>

<style>
</style>