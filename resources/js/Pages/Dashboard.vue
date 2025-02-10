<script setup>
import { defineProps } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Sidebar from '@/Components/Sidebar.vue'; // Import the Sidebar component

// Define props to accept data from the server
const { totalClients, totalBilling, pendingPayments } = defineProps({
  totalClients: {
    type: Number,
    required: true, // Ensure totalClients is always passed
  },
  totalBilling: {
    type: Number,
    required: true, // Ensure totalBilling is always passed
  },
  pendingPayments: {
    type: Number,
    required: true, // Ensure pendingPayments is always passed
  },
});
</script>

<template>
  <AuthenticatedLayout>
    <!-- Sidebar Component -->
    <Sidebar />

    <!-- Main Content Area -->
    <div class="main-content">
      <div class="header">
        <h1 class="welcome-heading">Welcome to the Dashboard</h1>
      </div>

      <div class="overview-stats">
        <!-- Total Clients Card -->
        <div class="stat-card">
          <h3>Client Count</h3>
          <p>{{ totalClients }}</p>
        </div>

        <!-- Total Billing Records Card (count of all records) -->
        <div class="stat-card">
          <h3>Total Billing Records</h3>
          <p>{{ totalBilling }}</p> <!-- Display the count of all billing records -->
        </div>

        <!-- Pending Payments Card -->
        <div class="stat-card">
          <h3>Pending Payments</h3>
          <p>{{ pendingPayments }}</p>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped src="/resources/css/dashboard.css"></style>
