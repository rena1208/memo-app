<template>
  <div>
    <table class="app-title">
      <tr>
        <td><h1>めも</h1></td>
        <!-- <div>{{ users }}</div> -->
        <td>
          <img
            class="icon"
            src="/assets/image/21459b5b441dbb499eb8b11cccbf2306_t.jpeg"
          />
        </td>
      </tr>
    </table>
    <div class="title-line">
      <img class="line" src="/assets/image/imagesa.png" />
    </div>
    <div v-if="errors.length" class="alert alert-danger">
      <ul>
        <li v-for="error in errors" :key="error">
          {{ errors }}
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

        <button type="button" @click="login">ログイン</button>
      </form>
    </div>
  </div>
</template>

<script setup>
// definePageMeta({
//   middleware: "guest",
// });
// // 初期値の設定
// const email = ref("");
// const password = ref("");
// const { $sanctumAuth } = useNuxtApp();
// // console.log($sanctumAuth);
// // const { $sanctumAuth } = useSanctumAuth();
// const router = useRouter();
// const errors = ref([]);
// // await $apiFetch("sanctum/csrf-cookie");
// // let token; // tokenの宣言
// // await useFetch("http://localhost:8000/sanctum/csrf-cookie", {
// //   method: "GET",
// //   mode: "cors",
// //   credentials: "include",
// // });

// async function login() {
//   console.log("おした");
//   console.log(email.value);
//   console.log(password.value);
//   try {
//     await $sanctumAuth.login(
//       {
//         email: email.value, // フォームで入力されたメールアドレス
//         password: password.value, // フォームで入力されたパスワード
//       },
//       // optional callback function
//       (data) => {
//         // $sanctumAuth.getUser(); // fetch and set user data
//         console.log(data);
//         router.push("/show");
//       }
//     );
//     console.log(email.value);
//     console.log(password.value);
//   } catch (e) {
//     // 認証エラー時の処理
//     console.log(e.errors);
//     errors.value = ["メールアドレス、もしくはパスワードが違います。"];
//     router.push("/login");
//   }
// }

// const { data: users } = await useFetch("http://127.0.0.1:8000/api/users");
// 初期値の設定
// const email = ref("");
// const password = ref("");
definePageMeta({
  middleware: "guest",
});
const { $sanctumAuth } = useNuxtApp();

// console.log($sanctumAuth);
// const { $sanctumAuth } = useSanctumAuth();
const router = useRouter();
const errors = ref([]);

// const { user, loggedIn } = useAuth(); // or useState('auth').value
// await $apiFetch("sanctum/csrf-cookie");
// await $apiFetch("http://localhost:8000/sanctum/csrf-cookie", {
//   method: "GET",
//   mode: "cors",
//   credentials: "include",
// });
// var token;

// await useFetch("http://localhost:8000/sanctum/csrf-cookie", {
//   method: "GET",
//   mode: "cors",
//   credentials: "include",
// }).then(() => {
//   token = document.cookie
//     .split("; ")
//     .find((row) => row.startsWith("XSRF-TOKEN"))
//     ?.split("=")[1];
// });
// const { data: csrf } = await useFetch("sanctum/csrf-cookie");
// console.log(csrf);

async function login() {
  console.log("おした");
  // const { data: csrf } = await useFetch("sanctum/csrf-cookie");
  // console.log(csrf);
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
    errors.value = ["メールアドレス、もしくはパスワードが違います。"];
    router.push("/login");
  }
}

// const { token } = useAuth();
</script>

<style>
.app-title {
  margin: auto;
  padding-bottom: 0;
}

h1 {
  font-size: 100px;
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
  margin: 3em 15em;
  color: #565656;
  background: #ffffdd;
  box-shadow: 0px 0px 0px 4px #fcc89e;
  border-radius: 8px;
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
  margin: 25px 3.5rem;
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
  margin: 10px 0;
  font-size: 15px;
}
.alert-danger {
  background: #ffd9d9;
  color: #ff4f4fe4;
  font-weight: bold;
}
</style>

