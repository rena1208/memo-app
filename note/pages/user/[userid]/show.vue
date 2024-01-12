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
      <p>
        <span>{{ loginUser.name }}</span
        >さんのメモ
      </p>
    </div>
    <button type="button" @click="logout">ログアウト</button>
    <!-- <div v-for="user in users" :key="user.id"> -->
    <div v-for="post in posts" :key="post.id">
      <h3>{{ post.title }}</h3>
      <p>{{ post.text }}</p>
    </div>
    <!-- </div> -->
    <!-- @foreach($users as $user)
  @foreach($user->posts as $post)
    <h3>{{$post->title}}</h3>
    <p>{{$post->content}}</p>
  @endforeach
@endforeach -->
    <!-- {{ postsData }} -->
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
const { $sanctumAuth } = useNuxtApp();

//パラメーターの取得
const router = useRouter();

const { user, loggedIn } = useAuth(); // or useState('auth').value

console.log("User Object:", user);
console.log("Is Logged In:", loggedIn);
const users = ref();
const errors = ref([]);
const { $apiFetch } = useNuxtApp();
//ログインユーザー情報の取得
const { data: postsData } = await useAsyncData("user", () =>
  $apiFetch(`api/user/{userid}`)
);

const posts = postsData.value.posts;
const loginUser = postsData.value.user;
// console.log(posts);
console.log(postsData);
console.log(loginUser);
// console.log(postsData.value.posts);
console.log(postsData.value.user);
//パラメータの取得
// async function asyncData({ params }) {
//   const userid = params.userid;
//   // console.log(params.userid);
//   return { userid };
// }

//ログアウト機能
async function logout() {
  console.log("ログアウトを押した");
  await $sanctumAuth.logout(
    // optional callback function
    (data) => {
      console.log(data);
      router.push("/login");
    }
  );
}

//メモの投稿
async function postNote() {
  // await $apiFetch("sanctum/csrf-cookie");
  console.log("おした");
  //入力内容をポスト
  const { error, data: post } = await useAsyncData("post", () =>
    $apiFetch(`api/user/{userid}/post`, {
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
    // console.log(errors.value);
    console.log(error.value.data.errors);
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