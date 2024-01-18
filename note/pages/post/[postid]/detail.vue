<template>
  <div>
    {{ $route.params.postid }}
    <!-- <h3>{{ postDetail.title }}</h3> -->
    <!-- <p>{{ postDetail }}</p> -->
  </div>
</template>

<script setup>
definePageMeta({
  middleware: "auth",
});
const { $sanctumAuth } = useNuxtApp();
//パラメーターの取得
const router = useRouter();

const { user, loggedIn } = useAuth(); // or useState('auth').value
console.log("User Object:", user);
console.log("Is Logged In:", loggedIn);
// const users = ref();
const errors = ref([]);
//ログインユーザー情報の取得
const { data: postsData } = await useAsyncData("user", () =>
  $apiFetch(`api/user/{userid}`)
);
console.log(postsData);
const { data: postDetail } = await useFetch(`api/user/{userid}/post/{postid}`);
console.log(postDetail);
</script>