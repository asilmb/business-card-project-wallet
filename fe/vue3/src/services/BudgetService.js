import api from './api'
import { API_ENDPOINTS } from '@/api/endpoints';

export const getBudget = () => {
    return api.get(API_ENDPOINTS.budget.base)
}

export const createBudget = (budgetData) => {
    return api.post(API_ENDPOINTS.budget.base, budgetData)
}

export const addAccount = (accountData) => {
    return api.post(API_ENDPOINTS.budget.addAccount, accountData)
}