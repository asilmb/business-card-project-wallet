import { defineStore } from 'pinia';
import apiClient from '@/services/api';
import router from '@/router';
import { API_ENDPOINTS } from '@/api/endpoints';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('token') || null,
        isLoading: false,
        error: null,
    }),

    getters: {
        isLoggedIn: (state) => !!state.token,
    },

    actions: {
        async login(credentials) {
            this.isLoading = true;
            this.error = null;
            try {
                const response = await apiClient.post(API_ENDPOINTS.auth.login, credentials);
                this.token = response.data.token;
                localStorage.setItem('token', this.token);
                return true;
            } catch (err) {
                this.error = err.response?.data?.message || 'Invalid credentials.';
                this.token = null;
                localStorage.removeItem('token');
                return false;
            } finally {
                this.isLoading = false;
            }
        },

        async register(userInfo) {
            this.isLoading = true;
            this.error = null;
            try {
                await apiClient.post(API_ENDPOINTS.auth.register, userInfo);
                return true;
            } catch (err) {
                this.error = err.response?.data?.message || 'Registration failed.';
                return false;
            } finally {
                this.isLoading = false;
            }
        },

        logout() {
            this.token = null;
            localStorage.removeItem('token');
            router.push({ name: 'login' });
        },
    },
});