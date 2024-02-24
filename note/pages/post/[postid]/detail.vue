<template>
  <div>
    <AuthHeader :flashMessage="flashMessage" :snackbar="snackbar" />
    <div class="box">
      <p>作成日　　：{{ formatDate(postDetail.created_at) }}</p>
      <p>最終更新日：{{ formatDate(postDetail.updated_at) }}</p>
      <h3>{{ postDetail.title }}</h3>
      <p class="text">{{ postDetail.text }}</p>
    </div>
    <div class="flex_button">
      <button class="back-button" type="button" @click="$router.back()">
        もどる
      </button>
      <button class="button" type="button">
        <nuxt-link :to="`/post/${postDetail.id}/edit`"><a>編集</a></nuxt-link>
      </button>
    </div>
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

<style scoped>
.box {
  padding: 10px 1em;
  margin: 5.5rem auto;
  margin-bottom: 2rem;
  color: #565656;
  background: #fff0e2;
  box-shadow: 0px 0px 0px 4px #fcc89e;
  border-radius: 8px;
  width: 60%;
  height: 30rem;
}
p {
  margin: 3px 0;
}
h3 {
  padding-bottom: 5px;
  border-bottom: dashed 2px #fcc89e;
  text-align: center;
  font-size: 25px;
}
.text {
  white-space: pre-wrap;
  font-size: 20px;
}
.flex_button {
  justify-content: center;
  display: flex;
  flex-wrap: nowrap;
}
.button {
  margin: 10px;
  border-radius: 4px;
  background: #ffcda5;
  border: 3px solid #ff9845;
  font-family: "ヒラギノ丸ゴ Pro";
  font-weight: 800;
  font-size: 17px;
  letter-spacing: 2px;
  width: 6rem;
  height: 2.5rem;
  cursor: pointer;
}
a {
  color: #5e5d5d;
}
.back-button {
  margin: 10px;
  border-radius: 4px;
  background: #d3f392;
  border: 3px solid #a5ea1c;
  color: #5e5d5d;
  font-family: "ヒラギノ丸ゴ Pro";
  font-weight: 800;
  font-size: 17px;
  letter-spacing: 2px;
  width: 6rem;
  height: 2.5rem;
  cursor: pointer;
}
</style>