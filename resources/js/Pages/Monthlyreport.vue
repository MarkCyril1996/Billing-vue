<template>
  <div class="container">
    <!-- Sidebar -->
    <Sidebar />

    <!-- Main content area -->
    <div class="monthly-report-container">
      <div class="header">
        <h2>Monthly Report</h2>
      </div>

      <!-- Report Summary -->
      <div class="report-summary">
        <p><strong>Total Billing for {{ selectedMonth }}:</strong> </p>
      </div>

      <!-- Billing Table -->
      <div class="billing-table">
        <h2>Billing Data</h2>
        <table class="table">
          <thead>
            <tr>
              <th>Client Name</th>
              <th>Date</th>
              <th>Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="bill in billingData" :key="bill.id">
              <td>{{ bill.client_name }}</td>
              <td>{{ bill.billing_date }}</td>
              <td>${{ bill.amount }}</td>
              <td :class="getStatusClass(bill.payment_status)">{{ bill.payment_status }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '@/Components/Sidebar.vue';  // Import Sidebar component

export default {
  components: {
    Sidebar,  // Register the Sidebar component
  },
  props: {
    billingData: Array,
    selectedMonth: String,
  },
  computed: {
    filteredTotalBilling() {
      return this.billingData.reduce((total, bill) => total + bill.amount);
    },
  },
  methods: {
    getStatusClass(status) {
      if (status === 'Completed') return 'status-completed';
      if (status === 'Pending') return 'status-pending';
      return ''; // No class for other statuses
    },
  },
};
</script>


<style src="/resources/css/monthlyreport.css"></style>
