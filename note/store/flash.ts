import { defineStore } from 'pinia'

interface State {
    snack: boolean
}

export const useFlashStore = defineStore('flash', {
    state: (): State => ({
        snack: false,
    }),
    actions: {
        unsetSnackbar() {
            this.$reset()
        },
        setSnackbar() {
            this.snack = true
        },
    },
})