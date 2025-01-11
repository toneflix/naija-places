import { defineStore } from "pinia"
import { ref } from "vue"

export type User = { id: string, email: string, phone: string, imageUrl: string, fullname: string }

export const bootstrapStore = defineStore('bootstrap', () => {
    const user = ref<User>(<User>{})
    const token = ref<string | null>(null)
    const cache = ref<{
        [x: string]: string;
        pageTitle: string;
    }>({ pageTitle: '' })
    const redirect = ref<string | undefined>()

    function saveAuthUser (us: any, tk: string) {
        user.value = us
        token.value = tk
    }

    function clearAuth () {
        return new Promise(() => {
            token.value = null
            user.value = <User>{}
        })
    }

    function setRedirect (to?: string) {
        redirect.value = to
    }

    return { user, token, cache, redirect, clearAuth, setRedirect, saveAuthUser }
})
