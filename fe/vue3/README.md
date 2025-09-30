# Finance Wallet - Vue 3 Frontend

![License](https://img.shields.io/badge/License-MIT-yellow.svg)

A simple and modern frontend demo for a personal finance wallet API.  
Created as a **portfolio project** to showcase skills in **Vue 3**, **Vuetify**, and **Pinia**.

---

## Goal

The goal of this project is to demonstrate a clean, responsive, and secure single-page application (SPA) built with modern frontend technologies.  
It connects to a Symfony API for authentication and financial data management.

---

## Key Features

- User authentication with JWT
- Centralized state management (Pinia)
- Responsive Material Design UI (Vuetify 3)
- Routing with navigation guards
- Budget and account management demo

---

## Tech Stack

- Vue 3 (Composition API)
- Vite
- Vuetify 3
- Pinia
- Vue Router
- Axios

---

## Project Setup

### Prerequisites

- Node.js (v18 or higher recommended)  
- npm or yarn  

### Installation

Clone the repository:

```bash
git clone git@github.com:asilmb/business-card-project-wallet.git
```

Navigate to the project directory:

```bash
cd fe/vue3
```

Install dependencies:

```bash
npm install
```

### Environment Variables

Create a `.env.development` file in the root of the project (`fe/vue3`).  
This file will contain the URL for the backend API.

```env
# .env.development
VITE_API_BASE_URL=http://localhost:8000/api
```

---

## Running the Application

### Development Server

Run the app with hot-reloading:

```bash
npm run dev
```

The application will be available at:  
👉 [http://localhost:5173](http://localhost:5173) (or another port if 5173 is in use).

---

## Backend Requirement

This is a **frontend-only** application.  
To run it fully, you need the corresponding backend API which handles authentication, database interactions, and business logic.  

---

## License

This project is licensed under the **MIT License**.  
See the [LICENSE](./LICENSE) file for details.
