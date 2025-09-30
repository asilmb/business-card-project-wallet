<template>
  <div>
    <div v-if="isLoading" class="text-center">
      <v-progress-circular indeterminate color="primary"></v-progress-circular>
      <p>Loading data...</p>
    </div>

    <v-alert v-else-if="error" type="error" prominent>
      {{ error }}
    </v-alert>


    <div v-if="budget">
      <h1 class="mb-4">{{ budget.name }}</h1>
      <p class="subtitle-1">Base Currency: {{ budget.currency }}</p>

      <v-divider class="my-4"></v-divider>

      <div class="d-flex align-center mb-2">
        <h2 class="mr-2">Accounts</h2>
        <v-btn
            icon="mdi-plus"
            color="success"
            variant="flat"
            size="small"
            @click="isAddAccountDialogOpen = true"
        ></v-btn>
      </div>

      <v-row v-if="accounts.length > 0">
        <v-col v-for="account in accounts" :key="account.name" cols="12" md="4">
          <v-card class="mt-2" variant="outlined">
            <v-card-title>{{ account.name }}</v-card-title>
            <v-card-subtitle>{{ account.currency }}</v-card-subtitle>
            <v-card-text class="text-h5">
              {{ formatCurrency(account.balance, account.currency) }}
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <p v-else class="mt-4">
        No accounts have been added yet. Click the '+' to add one.
      </p>
    </div>

    <AddAccountDialog v-model:is-open="isAddAccountDialogOpen" />
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { storeToRefs } from 'pinia'
import { useBudgetStore } from '@/stores/budget'
import { useRouter } from 'vue-router'
import AddAccountDialog from '@/components/AddAccountDialog.vue'
import { formatCurrency } from '@/utils'

const budgetStore = useBudgetStore()
const router = useRouter()

const { budget, accounts, isLoading, error } = storeToRefs(budgetStore)
const isAddAccountDialogOpen = ref(false)

onMounted(async () => {
  if (!budget.value) {
    await budgetStore.fetchBudget()
  }

  if (!isLoading.value && !error.value && !budget.value) {
    router.push({ name: 'dashboard' })
  }
})
</script>