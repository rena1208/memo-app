<template>
  <div>
    <h2>メモ一覧</h2>
    <div v-if="loggedIn">
      What is users name?
      <span>{{ user.name }}</span>
    </div>
    {{ posts }}
    <h2>メモ入力</h2>
    <form class="postNote-form">
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
const { user, loggedIn } = useAuth(); // or useState('auth').value

console.log("User Object:", user);
console.log("Is Logged In:", loggedIn);
const users = ref();
// const { data: posts } = await useAsyncData("posts", () => $apiFetch(`posts`));
const { $apiFetch } = useNuxtApp();
const { data: posts } = await useAsyncData("user", () => $apiFetch(`api/user`));
// const csrfToken = $sanctumAuth.csrfToken;
// console.log(csrfToken);
// const { token } = useAuth();

// await $apiFetch("sanctum/csrf-cookie");
// const { data: csrfToken } = await $apiFetch(`sanctum/csrf-cookie`);
// console.log(csrfToken);
// const response = await $apiFetch("sanctum/csrf-cookie");
// console.log(response);
// console.log(response.data);

// let token;

// await $apiFetch("http://localhost:8000/sanctum/csrf-cookie", {
//   method: "GET",
//   mode: "cors",
//   credentials: "include",
// }).then(() => {
//   token = document.cookie
//     .split("; ")
//     .find((row) => row.startsWith("XSRF-TOKEN"))
//     ?.split("=")[1];

//   token = decodeURIComponent(token);
// });
// console.log(token);
// const { data: csrf } = await useFetch("sanctum/csrf-cookie");
// console.log(csrf);

// const headers = {
//   // "Content-Type": "application/json",
//   // "X-XSRF-TOKEN": csrfToken,
//   "X-XSRF-TOKEN": document.cookie
//     .split("; ")
//     .find((row) => row.startsWith("XSRF-TOKEN"))
//     ?.split("=")[1],
//   Accept: "application/json",
// };

// console.log(token);

// $sanctumAuth.getUser(); // fetch and set user data

async function postNote() {
  // await $apiFetch("sanctum/csrf-cookie");
  console.log("おした");
  try {
    //入力内容をポスト
    const { data: post } = await useAsyncData("post", () =>
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
    // console.log(headers);
  } catch (e) {
    console.log(e.value);
    e.value = e.errors;
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
</style>