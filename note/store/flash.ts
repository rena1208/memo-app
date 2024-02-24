import { defineStore } from 'pinia'

interface State {
    snack: boolean
    text: string | null
}

export const useFlashStore = defineStore('flash', {
    state: (): State => ({
        snack: false,
        text: null,
    }),
    actions: {
        unsetSnackbar() {
            console.log("アクション関数");
            this.$reset()
            console.log(this.$reset);
        },
        setSnackbar(text: State['text']) {
            console.log("アクション関数");
            this.snack = true
            this.text = text
            console.log(this.snack)
            console.log(this.text);
        },
    },
})