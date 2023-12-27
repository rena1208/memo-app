// https://nuxt.com/docs/api/configuration/nuxt-config
// import { defineNuxtConfig } from 'nuxt/config'
// import nuxtSanctumAuth from '/dist/module.mjs'

export default defineNuxtConfig({
  ssr: false,
  devtools: { enabled: true },

  modules: [
    'nuxt-sanctum-auth'
  ],

  nuxtSanctumAuth: {
    token: false, // set true to use jwt-token auth instead of cookie. default is false
    baseUrl: 'http://localhost:8000',

    endpoints: {
      csrf: '/sanctum/csrf-cookie',
      login: '/api/login',
      logout: '/api/logout',
      user: '/api/user',
      // login: { url: "/api/login", method: "post" },
      // logout: { url: "/api/logout", method: "post" },
      // user: { url: "/api/user", method: "get" },
    },
    csrf: {
      header: 'X-XSRF-TOKEN',
      cookie: 'XSRF-TOKEN',
      tokenCookieKey: 'nuxt-sanctum-auth-token'
    },
    redirects: {
      home: '/show',
      login: '/login',
      logout: '/'
    }
  },
})

