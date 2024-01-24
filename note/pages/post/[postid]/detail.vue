<template>
  <div>
    <div class="box">
      <p>作成日　　：{{ formatDate(postDetail.created_at) }}</p>
      <p>最終更新日：{{ formatDate(postDetail.updated_at) }}</p>
      <h3>{{ postDetail.title }}</h3>
      <p class="text">{{ postDetail.text }}</p>
    </div>

    <button type="button" @click="$router.back()">もどる</button>
  </div>
</template>

<script setup>
import { format } from "date-fns/format";
definePageMeta({
  middleware: "auth",
});

//パラメーターの取得
const router = useRouter();
const { $apiFetch } = useNuxtApp();
const { $sanctumAuth } = useNuxtApp();

const { user, loggedIn } = useAuth(); // or useState('auth').value
console.log("User Object:", user);
console.log("Is Logged In:", loggedIn);
// const users = ref();
const errors = ref([]);
const postid = useRoute().params.postid;
// console.log($route.params.postid);
//メモの詳細情報を取得
const { data: postDetail } = await useAsyncData("post", () =>
  $apiFetch(`api/user/post/${postid}/detail`)
);
//メモの日付をyyyy年MM月dd日に変換
const formatDate = (dateTimeString) => {
  const date = new Date(dateTimeString);
  return format(date, "yyyy年MM月dd日");
};
// const formatDate = new Date();
// const date = format(formatDate, "yyyy年MM月dd日");
console.log(formatDate);
console.log(postDetail);
console.log(postid);
</script>
<style>
.box {
  padding: 10px 1em;
  margin: 1rem 20px;
  color: #565656;
  background: #fff0e2;
  box-shadow: 0px 0px 0px 4px #fcc89e;
  /* box-shadow: 0px 0px 0px 4px #e2f1ff; */
  border-radius: 8px;
  width: 60%;
  height: 30rem;
}
h3 {
  padding-bottom: 5px;
  border-bottom: dashed 2px #fcc89e;
  text-align: center;
  font-size: 25px;
}
.text {
  white-space: pre-wrap;
}
</style>