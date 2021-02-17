<template>
  <div class="px-4 py-4 my-4 shadow-md rounded-md bg-white">
    <Title :text="title" />
    <div class="grid grid-cols-3 gap-4">
      <slot />
    </div>
  </div>
</template>

<script>
import Title from "./Title.vue"
export default {
  components: { Title },
  name: "StatisticArea",
  props: ["title"],
}
</script>

<style>
</style>