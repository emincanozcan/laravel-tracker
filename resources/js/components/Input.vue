<template>
  <input
    type="text"
    class="mx-1 px-2 py-1 border border-gray-300 text-gray-700 rounded-md shadow-sm"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>

<script>
export default {
  name: "Input",
  props: ["modelValue"],
}
</script>

<style>
</style>