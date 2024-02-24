<template>
  <v-app-bar>
    <header v-if="loggedIn" class="header">
      <title>メモ帳アプリ</title>
      <nuxt-link :to="`/show`"><a>メモ一覧</a></nuxt-link>
      <a class="logout" @click="confirmLogout">ログアウト</a>
      <!-- <button type="button" @click="logout">ログアウト</button> -->
    </header>
    <header v-else class="header">
      <title>メモ帳アプリ</title>
      <nuxt-link :to="`/register`"><a>新規登録</a></nuxt-link>
      <nuxt-link :to="`/`"><a>ログイン</a></nuxt-link>
      <!-- <button type="button" @click="logout">ログアウト</button> -->
    </header>
  </v-app-bar>
</template>
<script setup>
import { ref, watch } from "vue";
// import { useAuthStore } from "~/store/auth";
import { useFlashStore } from "~/store/flash";

const flashStore = useFlashStore();

const { user, loggedIn } = useAuth(); // or useState('auth').value
// const authStore = useAuthStore();
// loggedIn = authStore.loggedIn;

// watch(
//   () => loggedIn,
//   (newValue, oldValue) => {
//     console.log("Is Logged In:", newValue);
//     console.log("Is Logged In:", oldValue);
//   }
// );
// console.log("User Object:", user);
console.log("Is Logged In:", loggedIn);

const flashMessage = ref("");
const snackbar = ref(false);

const { $sanctumAuth } = useNuxtApp();
const { $apiFetch } = useNuxtApp();
// const emit = defineEmits(["logout"]);
//パラメーターの取得
const router = useRouter();
//ログインユーザー情報の取得
const { data: postsData } = await useAsyncData("user", () =>
  // $apiFetch(`api/user/{userid}`)
  $apiFetch(`api/user`)
);

//ログアウト機能
async function confirmLogout() {
  const confirmed = confirm("ログアウトしますか？");
  if (confirmed) {
    await logout();
  }
}

async function logout() {
  console.log("ログアウトをおした");
  await $sanctumAuth.logout(
    // optional callback function
    (data) => {
      console.log(data);
      flashStore.setSnackbar("ログアウトしました");
      // emit("logout", {
      //   message: "ログアウトしました",
      //   isSnackbar: true,
      // });
      console.log(authStore);
      console.log(authStore.logout());
    }
  );
  window.location.href = "/";
}
</script>

<style scoped>
.header {
  background-color: #fcc89e;
  color: #fff;
  display: flex;
  margin: -200%; /* マージンを追記 */
  padding: 200%; /* マージンで横にはみ出した部分を戻す */
}
a {
  color: #fff;
  font-weight: bold;
  font-size: 18px;
  padding-left: 10px;
  cursor: pointer;
  text-decoration: none;
  text-align: right;
}
</style>