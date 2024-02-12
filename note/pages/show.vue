<template>
  <div v-if="loggedIn">
    <h2>
      <span>{{ loginUser.name }}</span
      >さんのメモ一覧
    </h2>
    <!-- <div v-for="user in users" :key="user.id"> -->
    <div class="flex">
      <div v-for="post in posts" :key="post.id">
        <div class="post">
          <h3 class="title" id="title">{{ post.title }}</h3>
          <p class="text" id="text">{{ post.text }}</p>
          <div class="flex_button">
            <button
              class="delete_button"
              type="button"
              @click="confirmDelete(post.id)"
            >
              削除
            </button>
            <button class="post_button" type="button">
              <nuxt-link :to="`post/${post.id}/detail`"><a>詳細</a></nuxt-link>
            </button>
          </div>
        </div>
      </div>
    </div>
    <p v-if="updatedPosts">{{ updatedPosts }}</p>
    <h2>メモ入力</h2>
    <form class="postNote-form">
      <div v-if="errors" class="alert alert-danger">
        <ul>
          <li v-for="error in errors" :key="error">
            <p v-for="e in error" :key="e">{{ e }}</p>
          </li>
        </ul>
      </div>
      <div class="box">
        <dl>
          <dt>タイトル　：</dt>
          <dd><input id="title" type="string" v-model="title" /></dd>
        </dl>
        <dl>
          <dt>メモ　：</dt>
          <dd><textarea id="text" type="text" v-model="text"></textarea></dd>
        </dl>
      </div>
      <button class="button" type="button" @click="postNote">保存！</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
definePageMeta({
  middleware: "auth",
});
const { $sanctumAuth } = useNuxtApp();
const { $apiFetch } = useNuxtApp();
//パラメーターの取得
const router = useRouter();

const { user, loggedIn } = useAuth(); // or useState('auth').value

// console.log("User Object:", user);
// console.log("Is Logged In:", loggedIn);
const users = ref();
const errors = ref([]);
const posts = ref([]);
const title = ref("");
const text = ref("");
const $config = useRuntimeConfig();
const emit = defineEmits(["postNote", "deletePost(postid)"]);

//ログインユーザー情報の取得
const { data: postsData } = await useAsyncData("user", () =>
  // $apiFetch(`api/user/{userid}`)
  $apiFetch(`api/user`)
);
console.log(posts);
console.log(postsData);

posts.value = postsData.value.posts;
// posts = postsData.value.posts;
// const posts = postsData.value.posts;
const loginUser = postsData.value.user;

// console.log(loginUser.id);
// console.log(postsData.value.posts);
// console.log(postsData.value.user);

//メモの削除機能
async function confirmDelete(postid) {
  const confirmed = confirm("本当に削除しますか？");
  if (confirmed) {
    await deletePost(postid);
  }
}

async function deletePost(postid) {
  console.log("削除をおした");
  console.log(postid);
  const { error, data: deletePost } = await useAsyncData("post", () =>
    $apiFetch(`api/user/post/${postid}`, {
      method: "DELETE",
    })
  );
  console.log(error);
  console.log(deletePost);
  if (error && error.value) {
    console.error("メモの削除に失敗しました", error);
  } else {
    console.log("メモを削除しました", deletePost);
    // メモ一覧を再取得
    // const { data: postsData } = await useAsyncData("user", () =>
    //   $apiFetch(`api/user`)
    // );
    posts.value = postsData.value.posts;
    console.log(posts.value); //削除前のメモたち
    console.log(deletePost); //削除したメモ
    console.log(postid); //削除したメモのID
    const postIndex = posts.value.findIndex(
      (deletePost) => deletePost.id === postid
    );
    console.log(postIndex);
    posts.value.splice(postIndex, 1); //削除
    emit("deletePost(postid)", {
      message: "メモを削除しました",
      isSnackbar: true,
    });
  }
}

//メモの投稿
async function postNote() {
  // await $apiFetch("sanctum/csrf-cookie");
  console.log("おした");
  //入力内容をポスト
  const { error, data: post } = await useAsyncData("post", () =>
    $apiFetch(`api/user/post`, {
      method: "POST",

      body: JSON.stringify({
        title: title.value,
        text: text.value,
      }),
    })
  );
  // console.log(title.value);
  // console.log(text.value);
  // console.log(post);
  // console.log(error.value.statusCode);
  // console.log(error.value.data.errors);
  // console.log(error);
  if (error && error.value && error.value.statusCode === 422) {
    // バリデーションエラーを含む何かしらのエラーがある場合
    errors.value = error.value.data.errors;
    // console.log(errors.value);
    console.log(error.value.data.errors);
  } else {
    console.log(posts.value); //ポスト前のメモたち
    console.log(post); //投稿したメモ
    postsData.value.posts.unshift(post.value.post);
    // posts.value.push(post.value.post);
    title.value = "";
    text.value = "";
    emit("postNote", {
      message: "メモを登録しました",
      isSnackbar: true,
    });
  }
}
</script>

<style scoped>
.flex {
  display: flex;
  flex-wrap: nowrap;
}
.post {
  padding: 10px 1em;
  margin: 1rem 20px;
  color: #565656;
  background: #fff0e2;
  box-shadow: 0px 0px 0px 4px #fcc89e;
  /* box-shadow: 0px 0px 0px 4px #e2f1ff; */
  border-radius: 8px;
  width: 190px;
}
.flex_button {
  justify-content: center;
  display: flex;
  flex-wrap: nowrap;
}
.post_button {
  margin: 0 5px;
  border-radius: 4px;
  background: #ffcda5;
  border: 1.5px solid #ff9845;
  color: #5e5d5d;
  font-family: "ヒラギノ丸ゴ Pro";
  font-weight: 800;
  font-size: 14px;
  letter-spacing: 1px;
  width: 4rem;
  height: 1.8rem;
  cursor: pointer;
}
.delete_button {
  margin: 0 5px;
  border-radius: 4px;
  background: #d3f392;
  border: 1.5px solid #a5ea1c;
  color: #5e5d5d;
  font-family: "ヒラギノ丸ゴ Pro";
  font-weight: 800;
  font-size: 14px;
  letter-spacing: 1px;
  width: 4rem;
  height: 1.8rem;
  cursor: pointer;
}
a {
  color: #5e5d5d;
}
.title {
  padding-bottom: 5px;
  border-bottom: dashed 2px #fcc89e;
}
p {
  white-space: pre-wrap;
}
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
  height: 15rem;
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
  padding-left: 15px;
  width: 200px;
}
dd {
  padding-top: 10px;
  width: calc(100% - 10px);
  text-align: left;
}
input {
  width: 80%;
  height: 20px;
}
textarea {
  width: 80%;
  height: 120px;
}
.button {
  display: block;
  margin: auto;
  border-radius: 4px;
  background: #fcc89e;
  border: 2.5px solid #ff9845;
  color: #5e5d5d;
  font-family: "ヒラギノ丸ゴ Pro";
  font-weight: 800;
  font-size: 17px;
  letter-spacing: 2px;
  width: 6rem;
  height: 2.5rem;
  cursor: pointer;
}
.flashButton {
  float: right;
  cursor: pointer;
}
</style>