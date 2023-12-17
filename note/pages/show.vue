<template>
  <div>
    <h2>メモ一覧</h2>
    <div v-if="loggedIn">
      What is users name?
      <span>{{ user.name }}</span>
    </div>
    {{ posts }}
    <h2>メモ入力</h2>
    <dl>
      <dt>タイトル　：</dt>
      <dd><input id="title" type="string" v-model="title" /></dd>
    </dl>
    <dl>
      <dt>メモ　：</dt>
      <dd><input id="text" type="text" v-model="text" /></dd>
    </dl>
  </div>
</template>

<script setup>
// export default {
//   created() {
//     console.log(this.$auth.user);
//   },
// };
const { $apiFetch } = useNuxtApp();
const { data: posts } = await useAsyncData("user", () => $apiFetch(`api/user`));
const { $sanctumAuth } = useNuxtApp();
// const { token } = useAuth();
const { user, loggedIn } = useAuth(); // or useState('auth').value

$sanctumAuth.getUser(); // fetch and set user data
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