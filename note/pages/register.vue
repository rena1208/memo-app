<template>
  <div>
    <h2>新規登録</h2>
    <div v-if="errors" class="alert alert-danger">
      <ul>
        <li v-for="error in errors" :key="error">
          <p v-for="e in error" :key="e">{{ e }}</p>
        </li>
      </ul>
    </div>
    <div class="box">
      <form class="postUser-form">
        <dl>
          <dt>名前　：</dt>
          <dd><input id="email" type="string" v-model="name" /></dd>
        </dl>
        <dl>
          <dt>メールアドレス　：</dt>
          <dd><input id="email" type="string" v-model="email" /></dd>
        </dl>
        <dl>
          <dt>メールアドレス確認用　：</dt>
          <dd>
            <input
              id="email_confirmation"
              type="string"
              v-model="email_confirmation"
            />
          </dd>
        </dl>
        <dl>
          <dt><label for="password">パスワード　：</label></dt>
          <dd><input id="password" type="password" v-model="password" /></dd>
        </dl>
        <dl>
          <dt>パスワード確認用　：</dt>
          <dd>
            <input
              id="password_confirmation"
              type="password"
              v-model="password_confirmation"
            />
          </dd>
        </dl>
        <p></p>
      </form>
    </div>
    <button type="button" @click="registerUser">登録！</button>
  </div>
</template>

<script setup>
definePageMeta({
  middleware: "guest",
});
// 初期値の設定
const name = ref("");
const email = ref("");
const email_confirmation = ref("");
const password = ref("");
const password_confirmation = ref("");

import { ref } from "vue";
// import { $sanctumAuth } from "nuxt-sanctum-auth";

const errors = ref([]);
const router = useRouter();

const { $sanctumAuth } = useNuxtApp();
const { $apiFetch } = useNuxtApp();
const $config = useRuntimeConfig();
const emit = defineEmits(["registerUser"]);

// console.log($config);

async function registerUser() {
  console.log("おした");
  //入力内容をポスト
  const { error, data: register } = await useFetch(`api/register`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    baseURL: $config.public.baseUrl,
    body: JSON.stringify({
      name: name.value,
      email: email.value,
      email_confirmation: email_confirmation.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    }),
  });

  // console.log(error.value.statusCode);
  // console.log(error.value.data.errors);
  console.log(register);
  console.log(error);
  if (error && error.value && error.value.statusCode === 422) {
    // バリデーションエラーがある場合
    // errors.value = e.text;
    errors.value = error.value.data.errors;
    console.log(error.value.data.errors);
  } else {
    //   // その他のエラー
    //   // console.error("Registration failed:", error.message);
    // }
    //ポストした内容でログイン
    try {
      await $sanctumAuth.login(
        {
          email: email.value,
          password: password.value,
        },
        (data) => {
          console.log(data);
          router.push(`/show`);
          emit("registerUser", {
            message: "ユーザーの登録ができました！",
            isSnackbar: true,
          });
        }
      );
    } catch (e) {
      console.error("ログインエラー:", e.errors);
    }
  }
}
</script>

<style scoped>
h2 {
  color: #565656;
  font-family: "ヒラギノ丸ゴ Pro";
  font-size: 30px;
  letter-spacing: 10px;
  text-align: center;
  margin: 60px auto;
}

.box {
  padding: 1em 1em;
  margin: 1.5rem auto;
  color: #565656;
  background: #ffffdd;
  box-shadow: 0px 0px 0px 4px #fcc89e;
  border-radius: 8px;
  text-align: center;
  justify-content: center;
  width: 60%;
  height: 25rem;
}

.postUser-form {
  display: block;

  text-align: center;
}
dl {
  display: flex;
  justify-content: space-between;
  background-size: 15px 2px;
  background-repeat: repeat-x;
  background-position: left bottom;
  margin: 25px 3.5rem;
}
dt {
  font-size: 18px;
  text-align: left;
  padding-top: 15px;
  width: 300px;
}
dd {
  padding-top: 10px;
  width: calc(100% - 100px);
  text-align: left;
}
input {
  width: 80%;
  height: 25px;
}
button {
  display: block;
  margin: 10px auto;
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