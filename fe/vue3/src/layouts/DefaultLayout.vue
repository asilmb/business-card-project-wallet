<template>
  <v-app>
    <v-app-bar app color="primary">
      <v-app-bar-title>Finance Wallet</v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn :to="{ name: 'dashboard' }" text>Dashboard</v-btn>
      <v-btn v-if="hasBudget" :to="{ name: 'budget' }" text>Budget</v-btn>
      <v-btn @click="handleLogout" icon>
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main class="bg-grey-lighten-3">
      <v-container>
        <slot />
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup>
import { storeToRefs } from 'pinia';
import { useAuthStore } from '@/stores/auth';
import { useBudgetStore } from '@/stores/budget';

const authStore = useAuthStore();
const budgetStore = useBudgetStore();

const { hasBudget } = storeToRefs(budgetStore);

const handleLogout = () => {
  budgetStore.clearBudget();
  authStore.logout();
};
</script>