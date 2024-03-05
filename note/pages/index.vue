<template>
  <div>
    <div class="title-flex">
      <h1 class="title">めも</h1>
      <!-- <div>{{ users }}</div> -->
      <div class="title">
        <img
          class="icon"
          src="/assets/image/21459b5b441dbb499eb8b11cccbf2306_t.jpeg"
        />
      </div>
    </div>
    <div class="title-line">
      <img class="line" src="/assets/image/imagesa.png" />
    </div>
    <div v-if="errors.length" class="alert alert-danger">
      <ul>
        <li v-for="error in errors" :key="error">
          {{ error }}
        </li>
      </ul>
    </div>
    <div class="box">
      <form class="login-form">
        <!-- <meta name="csrf-token" content="{{ csrf_token() }}" /> -->
        <dl>
          <dt>メールアドレス：</dt>
          <dd><input id="email" type="string" v-model="email" /></dd>
        </dl>
        <dl>
          <dt><label for="password">パスワード：</label></dt>
          <dd><input id="password" type="password" v-model="password" /></dd>
        </dl>
      </form>
    </div>
    <button type="button" @click="login">ログイン</button>
  </div>
</template>

<script setup>
import { useFlashStore } from "~/store/flash";
// import loginMessage from "~/components/LoginMessage.vue";
// import { ref } from "vue"; // Import ref if not already imported
definePageMeta({
  middleware: "guest",
});
// const props = defineProps({
//   flashMessage: String,
//   snackbar: Boolean,
// });
// console.log(props);
// console.log(snackbar);
const { $sanctumAuth } = useNuxtApp();

const router = useRouter();
const errors = ref([]);
const flashMessage = ref("");
const snackbar = ref(false);
const flashStore = useFlashStore();
// const emit = defineEmits(["flashStore.setSnackbar()"]);
//初期値の設定;
const email = ref("");
const password = ref("");
const $config = useRuntimeConfig();

console.log($config);

async function login() {
  console.log("おした");
  try {
    await $sanctumAuth.login(
      {
        email: email.value, // フォームで入力されたメールアドレス
        password: password.value, // フォームで入力されたパスワード
      },

      // optional callback function

      (data) => {
        // $sanctumAuth.getUser(); // fetch and set user data
        // console.log(params.userid);
        // console.log(data.id);
        console.log(data);
        // ログイン後にSnackbarを表示
        flashStore.setSnackbar("ログインしました！！");
        // router.push("/show");
        // emit("flashStore.setSnackbar()", {
        //   message: "ログインしました！",
        //   isSnackbar: true,
        // });

        // console.log("loginSnacbar");
        // flashMessage.value = "ログインしました！";
        // snackbar.value = ref(true);
        // console.log(flashMessage.value);
        // console.log(snackbar.value);
        // router.push("/register");
        // router.push(`/user/{userid}/show`);
      }
    );
    //リダイレクト
    window.location.href = "/show";
  } catch (e) {
    // 認証エラー時の処理
    console.log(errors);
    console.log(errors.value);
    errors.value = ["メールアドレス、もしくはパスワードが間違っています"];
    router.push("/");
  }
}
</script>

<style scoped>
.title-flex {
  justify-content: center;
  display: flex;
  align-items: center;
}
.title {
  margin: 20px;
  margin-top: 100px;
}
h1 {
  font-size: 100px;
  letter-spacing: 3px;
  font-weight: bold;
  color: rgba(0, 0, 0, 0);
  text-shadow: 3.5px 3.5px 0 #ffeaea;
  -webkit-text-stroke: 2.5px #ffacac;
}

.icon {
  width: 100px;
  height: 100px;
}

.line {
  margin: 0 auto;
  width: 80%;
  height: 30px;
  padding-top: 0;
}

.title-line {
  text-align: center;
}

.box {
  padding: 1em 1em;
  margin: 3em 15em 2rem 15rem;
  color: #565656;
  background: #ffffdd;
  box-shadow: 0px 0px 0px 4px #fcc89e;
  border-radius: 8px;
  width: 60%;
  height: 15rem;
}
.login-form {
  display: block;
  margin: 0 auto;
  text-align: center;
}
dl {
  display: flex;
  justify-content: space-between;
  background-size: 15px 2px;
  background-repeat: repeat-x;
  background-position: left bottom;
  margin: 40px 3.5rem;
}
dt {
  font-size: 18px;
  text-align: left;
  padding-top: 15px;
  padding-left: 100px;
  width: 300px;
}
dd {
  padding-top: 10px;
  width: calc(100% - 50px);
  text-align: left;
}
input {
  width: 70%;
  height: 25px;
}
button {
  display: block;
  margin: 0 auto;
  border-radius: 4px;
  background: #ffcda5;
  border: 3px solid #ff9845;
  color: #5e5d5d;
  font-size: 16px;
  font-family: "ヒラギノ丸ゴ Pro";
  font-weight: 800;
  letter-spacing: 2px;
  width: 6rem;
  height: 2.5rem;
  cursor: pointer;
}
.alert-danger {
  background: #ffd9d9;
  color: #ff4f4fe4;
  font-weight: bold;
}
</style>

