<template>
  <select
    class="cursor-pointer mx-1 pl-2 pr-8 py-1 border border-gray-300 text-gray-700 rounded-md shadow-sm"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  >
    <slot></slot>
  </select>
</template>

<script>
export default {
  name: "Select",
  props: ["modelValue"],
}
</script>

<style>
</style>