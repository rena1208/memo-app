<template>
  <div>
    <!-- {{ props.snackbar }}
    {{ props.flashMessage }}
    {{ snackbar }}
    {{ flashMessage }} -->
    <v-snackbar
      v-model="flashStore.snack"
      color="success"
      location="top center"
      timeout="3000"
    >
      <a class="flashText">{{ flashStore.text }}</a>
      <v-btn class="flashButton" @click="flashStore.unsetSnackbar()"
        >Close</v-btn
      >
    </v-snackbar>
  </div>
</template>

<script setup>
import { ref, watch, defineProps } from "vue";
import { useFlashStore } from "~/store/flash";

const flashStore = useFlashStore();
const props = defineProps({
  flashMessage: {
    type: String,
    defalt: "",
  },
  snackbar: {
    type: Boolean,
    defalt: false,
  },
});
// console.log(props);
// console.log(props.snackbar);
// console.log(props.flashMessage);
const snack = ref(props.snackbar);
// console.log(snack);
// console.log(props.snackbar);

watch(
  () => props.snackbar,
  (newSnack) => {
    snack.value = newSnack;
  }
);
</script>

<style scoped>
.flashText {
  padding-left: 10px;
  font-size: 17px;
}
.flashButton {
  float: right;
  cursor: pointer;
}
</style>