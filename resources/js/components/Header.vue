<template>
  <header class="w-full bg-gray-800 py-4">
    <container>
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-medium text-white tracking-wider">Tracker</h1>
      </div>
    </container>
  </header>
</template>

<script>
import Container from "./Container.vue"

export default {
  components: { Container },
  name: "Header",
}
</script>

<style>
</style>