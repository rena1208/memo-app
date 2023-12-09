<template>
  <div>
    <div v-if="loggedIn">
      What is users name?
      <span>{{ user.name }}</span>
    </div>
    <div>
      What is auth jwt token?
      <span>{{ token }}</span>
    </div>
    {{ posts }}
    <!-- <p>{{ $auth.loggedIn }}</p> -->
    <!-- <p>{{ $auth.user }}</p> -->
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