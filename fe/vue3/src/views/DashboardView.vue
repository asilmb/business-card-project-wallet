<template>
  <div>
    <h1>Dashboard</h1>
    <p>Welcome! You are successfully logged in.</p>

    <nav class="my-5">
      <div v-if="isBudgetLoading">
        <p>Loading budget info...</p>
      </div>
      <div v-else-if="budget">
        <v-btn :to="{ name: 'budget' }" color="primary" variant="flat">
          Manage My Budget
        </v-btn>
      </div>
      <div v-else>
        <v-btn @click="isDialogOpen = true" color="success" variant="flat">
          Create a New Budget
        </v-btn>
      </div>
    </nav>

    <v-divider class="my-5"></v-divider>

    <v-btn @click="handleLogout" color="error" variant="outlined">Logout</v-btn>

    <CreateBudgetDialog v-model:is-open="isDialogOpen" />
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'
import { useAuthStore } from '@/stores/auth'
import { useBudgetStore } from '@/stores/budget'
import CreateBudgetDialog from '@/components/CreateBudgetDialog.vue'

const router = useRouter()
const authStore = useAuthStore()
const budgetStore = useBudgetStore()

const { budget, isLoading: isBudgetLoading } = storeToRefs(budgetStore)
const isDialogOpen = ref(false)

const handleLogout = async () => {
  await authStore.logout()
  budgetStore.clearBudget()
  router.push({ name: 'login' })
}

onMounted(() => {
  if (!budgetStore.budget) {
    budgetStore.fetchBudget()
  }
})
</script>