import { defineStore } from 'pinia'
import { getBudget, createBudget as createBudgetApi, addAccount as addAccountApi } from '@/services/BudgetService'

export const useBudgetStore = defineStore('budget', {
    state: () => ({
        budget: null,
        isLoading: false,
        error: null
    }),

    getters: {
        hasBudget: (state) => state.budget !== null,
        accounts: (state) => state.budget?.accounts || []
    },

    actions: {
        async fetchBudget() {
            this.isLoading = true
            this.error = null
            try {
                const response = await getBudget()
                this.budget = response.data.data
                return true
            } catch (err) {
                if (err.response && err.response.status === 404) {
                    this.budget = null
                } else {
                    this.error = 'Failed to load budget data.'
                    console.error(err)
                }
                return false
            } finally {
                this.isLoading = false
            }
        },

        async createBudget(budgetData) {
            this.isLoading = true
            this.error = null
            try {
                await createBudgetApi(budgetData)
                await this.fetchBudget()
                return true
            } catch (err) {
                this.error = 'Failed to create budget.'
                console.error(err)
                return false
            } finally {
                this.isLoading = false
            }
        },

        async addAccount(accountData) {
            this.isLoading = true;
            this.error = null;
            try {
                await addAccountApi(accountData);
                await this.fetchBudget();
                return true;
            } catch (err) {
                this.error = err.response?.data?.message || 'Failed to add account.';
                return false;
            } finally {
                this.isLoading = false;
            }
        },

        clearBudget() {
            this.budget = null;
            this.error = null;
        }
    }
})