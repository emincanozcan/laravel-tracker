<template>
  <div class="flex items-center">
    <h3 class="w-3/4">{{ title }}</h3>
    <h3 class="w-1/4">{{ count }}</h3>
  </div>
</template>

<script>
export default {
  props: ["title", "colorClass", "count"],
}
</script>

<style>
</style>