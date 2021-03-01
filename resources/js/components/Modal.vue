<template>
  <transition name="modal">
    <div class="fixed left-0 top-0 w-full h-screen">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="modal-body">
            <slot />
          </div>
          <div class="modal-footer">
            <Button class="modal-default-button" @click="$emit('close')">
              Close
            </Button>
          </div>
        </div>
      </div>
      <div class="modal-mask" @click="$emit('close')"></div>
    </div>
  </transition>
</template>

<script>
import Button from "./Button.vue";
export default {
  name: "Modal",
  components: { Button },
};
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: -1;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: block;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  z-index: 99999;
  margin: 64px auto;
  display: block;
}

.modal-container {
  width: auto;
  max-width: 60vw;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  display: block;
  margin-top: 1rem;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>