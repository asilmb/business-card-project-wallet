<template>
  <v-dialog :model-value="isOpen" @update:model-value="$emit('update:isOpen', false)" max-width="500px">
    <v-card>
      <v-card-title>Add New Account</v-card-title>
      <v-card-text>
        <v-form ref="form" @submit.prevent="handleSubmit">
          <v-text-field
              v-model="accountName"
              label="Account Name"
              :disabled="isLoading"
              :rules="[validationRules.required]"
              variant="outlined"
          ></v-text-field>
          <v-text-field
              v-model="initialBalance"
              label="Initial Balance"
              type="number"
              :disabled="isLoading"
              :rules="[validationRules.required]"
              variant="outlined"
              class="mt-2"
          ></v-text-field>
          <p v-if="error" class="text-red mt-2">{{ error }}</p>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="$emit('update:isOpen', false)" :disabled="isLoading">Cancel</v-btn>
        <v-btn @click="handleSubmit" :loading="isLoading" color="primary" variant="flat">
          Add Account
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useBudgetStore } from '@/stores/budget'
import { validationRules } from '@/utils'
import { storeToRefs } from 'pinia'

const props = defineProps({
  isOpen: Boolean,
})

const emit = defineEmits(['update:isOpen'])

const budgetStore = useBudgetStore()
const { error } = storeToRefs(budgetStore)

const form = ref(null)
const isLoading = ref(false)
const accountName = ref('')
const initialBalance = ref(0)

const handleSubmit = async () => {
  const { valid } = await form.value.validate()
  if (!valid) return

  isLoading.value = true

  const balanceInCents = Math.round(Number(initialBalance.value) * 100);

  const success = await budgetStore.addAccount({
    name: accountName.value,
    initialBalance: balanceInCents,
  })
  isLoading.value = false

  if (success) {
    emit('update:isOpen', false)
  }
}

watch(() => props.isOpen, (newValue) => {
  if (newValue) {
    form.value?.reset()
    form.value?.resetValidation()
    accountName.value = ''
    initialBalance.value = 0
    budgetStore.error = null
  }
})
</script>