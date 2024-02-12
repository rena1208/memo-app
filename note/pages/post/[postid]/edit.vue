<template>
  <div>
    <AuthHeader />
    <h2>メモの編集</h2>
    <form class="editNote-form">
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
      <div class="flex_button">
        <button class="back-button" type="button" @click="$router.back()">
          もどる
        </button>
        <button class="button" type="button" @click="postEdit">保存！</button>
      </div>
    </form>
  </div>
</template>
<script setup>
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
const $config = useRuntimeConfig();
const emit = defineEmits(["postEdit"]);

//メモの情報を取得
const { data: post } = await useAsyncData("post", () =>
  $apiFetch(`api/user/post/${postid}/detail`)
);
console.log(post);
console.log(post.value.title);
const title = ref(post.value.title);
const text = ref(post.value.text);

//メモの更新
async function postEdit() {
  console.log("おした");
  const { error, data: postEdit } = await useAsyncData("post", () =>
    $apiFetch(`api/user/post/${postid}/edit`, {
      method: "POST",

      body: JSON.stringify({
        title: title.value,
        text: text.value,
      }),
    })
  );
  console.log(postEdit);

  // バリデーションエラーを含む何かしらのエラーがある場合
  if (error && error.value && error.value.statusCode === 422) {
    errors.value = error.value.data.errors;
    // console.log(errors.value);
    console.log(error.value);
  } else {
    router.push("/show");
    emit("postEdit", {
      message: "メモを編集しました",
      isSnackbar: true,
    });
  }
}
</script>
<style scoped>
h2 {
  color: #565656;
  font-family: "ヒラギノ丸ゴ Pro";
  font-size: 30px;
  letter-spacing: 10px;
  text-align: center;
  margin: 50px auto;
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
dl {
  display: flex;
  justify-content: space-between;
  background-size: 15px 2px;
  background-repeat: repeat-x;
  background-position: left bottom;
  margin: 40px 3.5rem;
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
  height: 25px;
  font-size: 15px;
}
textarea {
  width: 80%;
  height: 220px;
  font-size: 15px;
}
.alert-danger {
  background: #ffd9d9;
  color: #ff4f4fe4;
  font-weight: bold;
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
  color: #5e5d5d;
  font-family: "ヒラギノ丸ゴ Pro";
  font-weight: 800;
  font-size: 17px;
  letter-spacing: 2px;
  width: 6rem;
  height: 2.5rem;
  cursor: pointer;
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
