<template>
  <v-row justify="center" align="center" style="height: 80vh;">
    <v-col cols="12" sm="8" md="4">
      <v-card class="elevation-12">
        <v-toolbar color="primary" dark flat>
          <v-toolbar-title>Login</v-toolbar-title>
        </v-toolbar>

        <v-card-text>
          <v-form ref="form" @submit.prevent="handleLogin">
            <v-text-field
                v-model="email"
                label="Email"
                prepend-icon="mdi-email"
                type="email"
                required
                :rules="[validationRules.required, validationRules.email]"
                variant="outlined"
            ></v-text-field>

            <v-text-field
                v-model="password"
                label="Password"
                prepend-icon="mdi-lock"
                type="password"
                required
                :rules="[validationRules.required]"
                variant="outlined"
            ></v-text-field>

            <v-alert v-if="authError" type="error" density="compact" class="mb-4">
              {{ authError }}
            </v-alert>
          </v-form>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <RouterLink to="/register">Don't have an account?</RouterLink>
          <v-btn
              @click="handleLogin"
              :loading="isLoading"
              color="primary"
              variant="flat"
          >
            Login
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'
import { validationRules } from '@/utils'

const router = useRouter()
const authStore = useAuthStore()
const { isLoading, error: authError } = storeToRefs(authStore)

const form = ref(null)
const email = ref('')
const password = ref('')

const handleLogin = async () => {
  const { valid } = await form.value.validate()
  if (!valid) return

  const success = await authStore.login({
    email: email.value,
    password: password.value
  })

  if (success) {
    router.push({ name: 'dashboard' })
  }
}
</script>