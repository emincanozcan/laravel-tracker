<template>
  <div class="flex justify-between items-center px-6 py-4 shadow-md rounded-lg">
    <h3 class="font-medium">{{ title }}</h3>
    <h3 class="font-bold">{{ count }}</h3>
  </div>
</template>

<script>
export default {
  props: ["title", "count"],
}
</script>

<style>
</style>