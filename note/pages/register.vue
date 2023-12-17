<template>
  <div>
    <h2>新規登録</h2>
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
        <!-- <meta name="csrf-token" content="{{ csrf_token() }}" /> -->
        <button type="button" @click="registerUser">登録！</button>
      </form>
    </div>
  </div>
</template>

<script setup>
// 初期値の設定
const name = ref("");
const email = ref("");
const email_verified_at = ref("");
const password = ref("");
const passwordConfirm = ref("");

import { ref } from "vue";
// import { $sanctumAuth } from "nuxt-sanctum-auth";

const errors = ref([]);
const router = useRouter();

const { $sanctumAuth } = useNuxtApp();

async function registerUser() {
  console.log("おした");
  try {
    //入力内容をポスト
    const { data: register } = await useFetch(
      "http://127.0.0.1:8000/api/register",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          name: name.value,
          email: email.value,
          email_confirmation: email_confirmation.value,
          password: password.value,
          password_confirmation: password_confirmation.value,
        }),
      }
    );

    console.log(name.value);
    console.log(email.value);
    console.log(email_confirmation.value);
    console.log(password.value);
    console.log(password_confirmation.value);
    console.log(register);
  } catch (e) {
    console.log(errors.value);
    errors.value = e.errors;
  }
  //ポストした内容でログイン
  try {
    await $sanctumAuth.login(
      {
        email: email.value, // フォームで入力されたメールアドレス
        password: password.value, // フォームで入力されたパスワード
      },

      // optional callback function
      (data) => {
        // $sanctumAuth.getUser(); // fetch and set user data
        console.log(data);
        router.push("/show");
      }
    );
    console.log(email.value);
    console.log(password.value);
  } catch (e) {
    // 認証エラー時の処理
    console.log(e.errors);
    // router.push("/login");
  }
}
// const registerUser = async () => {
//   console.log("おした");
//   try {
//     const response = await $sanctumAuth.register({
//       name: name.value,
//       email: email.value,
//       email_confirmation: email_confirmation.value,
//       password: password.value,
//       password_confirmation: password_confirmation.value,
//     });

//     console.log(name.value);
//     console.log(email.value);
//     console.log(email_confirmation.value);
//     console.log(password.value);
//     console.log(password_confirmation.value);

//     (data) => {
//       // $sanctumAuth.getUser(); // fetch and set user data
//       console.log(data);
//       router.push("/show");
//     };
//   } catch (error) {
//     console.log(error);
//   }
// };
</script>

<style>
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
  height: 20px;
}
button {
  margin-top: 10px;
  font-size: 15px;
}
</style>