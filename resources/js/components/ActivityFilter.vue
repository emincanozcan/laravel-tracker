<template>
  <label class="text-gray-700 mx-2">
    <div class="mb-1">{{ text }}</div>
    <div><slot /></div>
  </label>
</template>

<script>
export default {
  name: "ActivityFilter",
  props: ["text"],
}
</script>

<style>
</style>