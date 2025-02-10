<template>
  <div class="dashboard">
    <Sidebar />

    <div class="billing-list-container">
      <header class="header">
        <h2>Billing List</h2>
        <button class="add-billing-button" @click="openAddBillingForm">Add Billing</button>
      </header>

      <div class="billing-list">
        <table>
          <thead>
            <tr>
              <th>Billing ID</th>
              <th>Client Name</th>
              <th>Meter Cubic Usage</th>
              <th>Amount</th>
              <th>Payment Status</th>
              <th>Billing Cycle</th>
              <th>Billing Date</th>
              <th>Due Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="billing in billings" :key="billing.id">
              <td>{{ billing.id }}</td>
              <td>{{ getClientName(billing.client_id) }}</td>
              <td>{{ billing.meter_cubic_usage }}</td>
              <td>{{ billing.amount }}</td>
              <td :class="{'status-pending': billing.payment_status === 'Pending', 'status-paid': billing.payment_status === 'Paid'}">
                {{ billing.payment_status }}
              </td>
              <td>{{ billing.billing_cycle }}</td>
              <td>{{ billing.billing_date }}</td>
              <td>{{ billing.due_date }}</td>
              <td>
                <button class="edit-button" @click="openEditBillingForm(billing)">Edit</button>
                <button class="delete-button" @click="deleteBilling(billing.id)">Delete</button>
                <button class="print-button" @click="printIndividualBilling(billing)">Print</button> <!-- Print Button for each billing -->
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <a href="/dashboard" class="back-to-dashboard-link">Back to Dashboard</a>
    </div>

    <!-- Add/Edit Billing Modal -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close-button" @click="closeModal">&times;</span>
        <h2>{{ newBilling.id ? 'Edit Billing' : 'Add New Billing' }}</h2>
        <form @submit.prevent="newBilling.id ? editBilling() : addBilling()">
          <div class="form-group">
            <label for="clientName">Client Name</label>
            <select v-model="newBilling.clientId" id="clientName" required>
              <option value="" disabled>Select a client</option>
              <option v-for="client in clients" :key="client.id" :value="client.id">
                {{ client.name }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="meterCubicUsage">Meter Cubic Usage</label>
            <input v-model="newBilling.meterCubicUsage" id="meterCubicUsage" type="number" @input="calculateAmount" required />
          </div>
          <div class="form-group">
            <label for="amount">Amount</label>
            <input v-model="newBilling.amount" id="amount" type="number" readonly />
          </div>
          <div class="form-group">
            <label for="paymentStatus">Payment Status</label>
            <select v-model="newBilling.paymentStatus" id="paymentStatus">
              <option value="Pending">Pending</option>
              <option value="Paid">Paid</option>
            </select>
          </div>
          <div class="form-group">
            <label for="billingCycle">Billing Cycle</label>
            <select v-model="newBilling.billingCycle" id="billingCycle">
              <option value="Monthly">Monthly</option>
              <option value="Quarterly">Quarterly</option>
            </select>
          </div>
          <div class="form-group">
            <label for="billingDate">Billing Date</label>
            <input v-model="newBilling.billingDate" id="billingDate" type="date" required />
          </div>
          <div class="form-group">
            <label for="dueDate">Due Date</label>
            <input v-model="newBilling.dueDate" id="dueDate" type="date" required />
          </div>
          <div class="button-group">
            <button type="submit" :disabled="isLoading">{{ newBilling.id ? 'Update Billing' : 'Add Billing' }}</button>
            <button type="button" @click="closeModal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Sidebar from '@/Components/Sidebar.vue';

const pricePerCubicMeter = 10;

const calculateAmount = () => {
  newBilling.value.amount = newBilling.value.meterCubicUsage * pricePerCubicMeter;
};

const billings = ref([]);
const clients = ref([]);
const showModal = ref(false);
const isLoading = ref(false);
const newBilling = ref({
  id: null,  // Add an ID field to track if it's a new or existing billing
  clientId: '',
  amount: '',
  paymentStatus: 'Pending',
  billingCycle: 'Monthly',
  billingDate: '',
  dueDate: '',
  meterCubicUsage: '',
});

onMounted(async () => {
  try {
    const billingResponse = await axios.get('/billings');
    billings.value = billingResponse.data;

    const clientsResponse = await axios.get('/clients'); // Add a route for fetching clients
    clients.value = clientsResponse.data;

    console.log('Billings:', billings.value);
    console.log('Clients:', clients.value);
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});

const openAddBillingForm = () => {
  showModal.value = true;
  resetNewBillingForm();
};

const openEditBillingForm = (billing) => {
  showModal.value = true;
  newBilling.value = {
    id: billing.id,
    clientId: billing.client_id,
    amount: billing.amount,
    paymentStatus: billing.payment_status,
    billingCycle: billing.billing_cycle,
    billingDate: billing.billing_date,
    dueDate: billing.due_date,
    meterCubicUsage: billing.meter_cubic_usage,
  };
};

const closeModal = () => {
  showModal.value = false;
  resetNewBillingForm();
};

const resetNewBillingForm = () => {
  newBilling.value = {
    id: null,
    clientId: '',
    amount: '',
    paymentStatus: 'Pending',
    billingCycle: 'Monthly',
    billingDate: '',
    dueDate: '',
    meterCubicUsage: '',
  };
};

const getClientName = (clientId) => {
  const client = clients.value.find(client => client.id === clientId);
  return client ? client.name : 'Client not found';
};

const addBilling = async () => {
  if (isFormValid()) {
    isLoading.value = true;
    try {
      const response = await axios.post('/billings', { ...newBilling.value });
      billings.value.push(response.data);
      closeModal();
    } catch (error) {
      isLoading.value = false;
      alert(`Error adding billing: ${error.response?.data?.message || error.message}`);
    }
  } else {
    alert('Please fill out all fields.');
  }
};

const editBilling = async () => {
  if (isFormValid()) {
    isLoading.value = true;
    try {
      const response = await axios.put(`/billings/${newBilling.value.id}`, { ...newBilling.value });
      const index = billings.value.findIndex(billing => billing.id === newBilling.value.id);
      if (index !== -1) {
        billings.value[index] = response.data;
      }
      closeModal();
    } catch (error) {
      isLoading.value = false;
      alert(`Error updating billing: ${error.response?.data?.message || error.message}`);
    }
  } else {
    alert('Please fill out all fields.');
  }
};

const isFormValid = () => {
  if (newBilling.value.meterCubicUsage && newBilling.value.amount === '') {
    calculateAmount();  // Ensure the amount is calculated if meter cubic usage is provided
  }

  return newBilling.value.clientId && newBilling.value.meterCubicUsage && newBilling.value.amount &&
         newBilling.value.paymentStatus && newBilling.value.billingCycle && newBilling.value.billingDate &&
         newBilling.value.dueDate;
};

const deleteBilling = async (id) => {
  try {
    await axios.delete(`/billings/${id}`);
    billings.value = billings.value.filter(billing => billing.id !== id);
    alert('Billing record deleted successfully');
  } catch (error) {
    alert(`Error deleting billing: ${error.response?.data?.message || error.message}`);
  }
};

// Print individual billing record function
const printIndividualBilling = (billing) => {
  const printWindow = window.open('', '_blank');
  
  // Create a simple HTML structure for printing the billing details
  printWindow.document.write('<html><head><title>Billing Details</title>');
  printWindow.document.write('<link rel="stylesheet" href="/resources/css/billing.css">'); // Include your CSS file
  printWindow.document.write('</head><body>');
  printWindow.document.write(`
    <h2>Billing ID: ${billing.id}</h2>
    <p><strong>Client:</strong> ${getClientName(billing.client_id)}</p>
    <p><strong>Meter Cubic Usage:</strong> ${billing.meter_cubic_usage}</p>
    <p><strong>Amount:</strong> ${billing.amount}</p>
    <p><strong>Payment Status:</strong> ${billing.payment_status}</p>
    <p><strong>Billing Cycle:</strong> ${billing.billing_cycle}</p>
    <p><strong>Billing Date:</strong> ${billing.billing_date}</p>
    <p><strong>Due Date:</strong> ${billing.due_date}</p>
  `);
  printWindow.document.write('</body></html>');
  printWindow.document.close();
  
  printWindow.print();
};
</script>

<style src="/resources/css/billing.css"></style>
