<template>
  <!-- <table>
    <tbody>
      <tr class="" v-for="user in data.users" :key="user.id">
        <th>{{ user.name }}</th>
        <td>{{ user.email }}</td>
      </tr>
    </tbody>
  </table> -->
  <v-app>
    <Header @logout="showSnackbar" />
    <FlashMessage :flashMessage="flashMessage" :snackbar="snackbar" />
    <!-- <NuxtPage
      @login="showSnackbar"
      @postNote="showSnackbar"
      @deletePost(postid)="showSnackbar"
      @postEdit="showSnackbar"
      @registerUser="showSnackbar"
      @logout="showSnackbar"
    /> -->
    <NuxtPage />
  </v-app>
</template>

<script setup>
import { ref } from "vue";
import { useFlashStore } from "~/store/flash";
// import loginSnacbar from "~/pages/login.vue";
// const { data } = await useFetch("http://127.0.0.1:8000/api/users");
const flashMessage = ref("");
const snackbar = ref(false);
const flashStore = useFlashStore();

function showSnackbar({ message, isSnackbar }) {
  console.log("ログインメッセージ表示の関数");
  flashMessage.value = message;
  snackbar.value = isSnackbar;
  console.log(message);
  console.log(isSnackbar);
}
</script>

<style scoped>
html {
  overflow: auto;
}

body {
  overflow: hidden; /*はみ出た部分をどうするか*/
}
</style>
