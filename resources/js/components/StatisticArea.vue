<template>
  <div class="px-4 py-4 my-4 shadow-md rounded-md bg-white">
    <div class="mb-4 text-2xl font-medium text-gray-700">{{ title }}</div>
    <div class="grid grid-cols-3 gap-4">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: "StatisticArea",
  props: ["title"],
}
</script>

<style>
</style>