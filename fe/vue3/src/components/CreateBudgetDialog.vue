<template>
  <v-dialog :model-value="isOpen" @update:model-value="close" max-width="500px">
    <v-card>
      <v-card-title>Create New Budget</v-card-title>
      <v-card-text>
        <v-form @submit.prevent="handleSubmit" ref="form">
          <v-text-field
              v-model="budgetName"
              label="Budget Name"
              :disabled="isLoading"
              :rules="[rules.required]"
              required
              variant="outlined"
          ></v-text-field>

          <v-select
              v-model="selectedCurrency"
              :items="currencyOptions"
              label="Base Currency"
              :disabled="isLoading"
              :rules="[rules.required]"
              required
              variant="outlined"
              class="mt-2"
          ></v-select>

          <p v-if="error" class="text-red mt-2">{{ error }}</p>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn @click="close" :disabled="isLoading">Cancel</v-btn>
        <v-btn
            @click="handleSubmit"
            :loading="isLoading"
            color="primary"
            variant="flat"
        >
          Create
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { useBudgetStore } from '@/stores/budget'
import { CURRENCIES, DEFAULT_CURRENCY } from '@/constants'
import { rules } from '@/utils/validationRules'

const props = defineProps({
  isOpen: {
    type: Boolean,
    required: true
  }
})

const emit = defineEmits(['update:isOpen', 'created'])

const budgetStore = useBudgetStore()
const { error } = storeToRefs(budgetStore)
const isLoading = ref(false)
const form = ref(null)

const budgetName = ref('')
const selectedCurrency = ref(DEFAULT_CURRENCY)
const currencyOptions = CURRENCIES

const close = () => {
  emit('update:isOpen', false)
}

const handleSubmit = async () => {
  const { valid } = await form.value.validate()
  if (!valid) return

  isLoading.value = true
  budgetStore.error = null

  const success = await budgetStore.createBudget({
    name: budgetName.value,
    currency: selectedCurrency.value
  })

  isLoading.value = false
  if (success) {
    emit('created')
    close()
  }
}

watch(() => props.isOpen, (newValue) => {
  if (!newValue) {
    budgetName.value = ''
    selectedCurrency.value = DEFAULT_CURRENCY
    budgetStore.error = null
    isLoading.value = false
  }
})
</script>