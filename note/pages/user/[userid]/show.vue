<template>
  <div>
    <!-- {{ $route.params.userid }} -->
    <!-- <div v-if="session('flash')" class="alert alert-danger">
      <ul>
        <li v-for="error in errors" :key="error">
          {{ error }}
        </li>
      </ul>
    </div> -->
    <h2>メモ一覧</h2>
    <div v-if="loggedIn">
      What is users name?
      <span>{{ user.name }}</span>
    </div>
    {{ posts }}
    <h2>メモ入力</h2>
    <form class="postNote-form">
      <div v-if="errors" class="alert alert-danger">
        <ul>
          <li v-for="error in errors" :key="error">
            {{ error }}
          </li>
        </ul>
      </div>
      <!-- <meta name="csrfToken" content="{{ csrfToken() }}" /> -->
      <dl>
        <dt>タイトル　：</dt>
        <dd><input id="title" type="string" v-model="title" /></dd>
      </dl>
      <dl>
        <dt>メモ　：</dt>
        <dd><textarea id="text" type="text" v-model="text"></textarea></dd>
      </dl>
      <button type="button" @click="postNote">保存！</button>
    </form>
  </div>
</template>

<script setup>
definePageMeta({
  middleware: "auth",
});

//パラメーターの取得
// const { useContext, useNuxtApp } = useSetupContext();
// const { params, useRouter } = useContext();
// const userid = params.userid;
const router = useRouter();

const { user, loggedIn } = useAuth(); // or useState('auth').value

console.log("User Object:", user);
console.log("Is Logged In:", loggedIn);
const users = ref();
const errors = ref([]);
const { $apiFetch } = useNuxtApp();
const { data: posts } = await useAsyncData("user", () =>
  $apiFetch(`api/user/{userid}`)
);

//パラメータの取得
// async function asyncData({ params }) {
//   const userid = params.userid;
//   // console.log(params.userid);
//   return { userid };
// }

async function postNote() {
  // await $apiFetch("sanctum/csrf-cookie");
  console.log("おした");
  //入力内容をポスト
  const { error, data: post } = await useAsyncData("post", () =>
    $apiFetch(`api/post`, {
      method: "POST",

      body: JSON.stringify({
        title: title.value,
        text: text.value,
      }),
    })
  );
  console.log(title.value);
  console.log(text.value);
  console.log(post);
  // console.log(error.value.statusCode);
  // console.log(error.value.data.errors);
  // console.log(error);
  if (error && error.value && error.value.statusCode === 422) {
    // バリデーションエラーを含む何かしらのエラーがある場合
    errors.value = error.value.data.errors;
    console.log(errors.value);
  }
}
</script>

<style>
h2 {
  color: #565656;
  font-family: "ヒラギノ丸ゴ Pro";
  font-size: 35px;
  letter-spacing: 10px;
  text-align: center;
  margin: 0;
}
.alert-danger {
  background: #ffd9d9;
  color: #ff4f4fe4;
  font-weight: bold;
}
</style>