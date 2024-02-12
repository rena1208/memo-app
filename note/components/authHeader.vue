<template>
  <div v-if="loggedIn">
    <header class="authHeader">
      <title>メモ帳アプリ</title>
      <p><a>メモ一覧</a></p>
      <p><a class="logout" @click="confirmLogout">ログアウト</a></p>
      <!-- <button type="button" @click="logout">ログアウト</button> -->
    </header>
  </div>
</template>
<script setup>
definePageMeta({
  middleware: "auth",
});
const { user, loggedIn } = useAuth(); // or useState('auth').value
console.log("User Object:", user);
console.log("Is Logged In:", loggedIn);

const { $sanctumAuth } = useNuxtApp();
const { $apiFetch } = useNuxtApp();
const emit = defineEmits(["logout"]);
//パラメーターの取得
const router = useRouter();
//ログインユーザー情報の取得
const { data: postsData } = await useAsyncData("user", () =>
  // $apiFetch(`api/user/{userid}`)
  $apiFetch(`api/user`)
);
console.log(postsData);

//ログアウト機能
async function confirmLogout() {
  const confirmed = confirm("ログアウトしますか？");
  if (confirmed) {
    await logout();
  }
}

async function logout() {
  console.log("ログアウトを押した");
  await $sanctumAuth.logout(
    // optional callback function
    (data) => {
      console.log(data);
      router.push("/login");

      emit("logout", {
        message: "ログアウトしました",
        isSnackbar: true,
      });
    }
  );
}
</script>

<style>
.authHeader {
  background-color: #fcc89e;
  color: #fff;
  display: flex;
  width: 100%;
  margin: 0;
  min-width: 1040px;
}
.logout {
  cursor: pointer;
}
</style>