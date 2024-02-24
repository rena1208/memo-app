import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        loggedIn: false
    }),
    actions: {
        login() {
            // ログインの処理
            this.loggedIn = true
        },
        logout() {
            // ログアウトの処理
            this.loggedIn = false
        }
    }
})