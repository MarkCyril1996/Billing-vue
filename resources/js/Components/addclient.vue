<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Components/Sidebar.vue';
import axios from 'axios';  // To make API requests

const clients = ref([]);

// States
const showModal = ref(false);
const newClient = ref({
  name: '',
  email: '',
  phone: '',
  status: 'Active',
});

// Function to add client
const addClient = async () => {
  try {
    // Send data to backend API
    const response = await axios.post('/api/clients', newClient.value);

    // Handle success (e.g., display a success message)
    console.log('Client added:', response.data);
    alert('Client added successfully!');

    // Add the new client to the clients list
    clients.value.push(response.data.client);

    // Reset the form and close the modal
    closeModal();
  } catch (error) {
    // Handle error (e.g., display an error message)
    console.error('Error adding client:', error.response || error);
    alert('Failed to add client. Please try again.');

    if (error.response && error.response.data) {
      alert(error.response.data.message || 'Something went wrong.');
    }
  }
};

// Function to open the modal
const openAddClientForm = () => {
  showModal.value = true;
};

// Function to close the modal
const closeModal = () => {
  showModal.value = false;
  newClient.value = { name: '', email: '', phone: '', status: 'Active' }; // Reset form
};

</script>

<template>
  <div class="dashboard">
    <!-- Sidebar Component -->
    <Sidebar />

    <!-- Client List Section -->
    <div class="client-list-container">
      <header class="header">
        <h2>Client List</h2>
        <!-- Add Client Button -->
        <button class="add-client-button" @click="openAddClientForm">Add Client</button>
      </header>
      <div class="client-list">
        <table>
          <thead>
            <tr>
              <th>Client ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in clients" :key="client.id">
              <td>{{ client.id }}</td>
              <td>{{ client.name }}</td>
              <td>{{ client.email }}</td>
              <td>{{ client.phone }}</td>
              <td :class="{'status-inactive': client.status === 'Inactive', 'status-active': client.status === 'Active'}">
                {{ client.status }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <a href="/dashboard" class="back-to-dashboard-link">
        Back to Dashboard
      </a>
    </div>

    <!-- Add Client Modal -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close-button" @click="closeModal">&times;</span>
        <h2>Add New Client</h2>
        <form @submit.prevent="addClient">
          <div class="form-group">
            <label for="name">Name</label>
            <input v-model="newClient.name" id="name" type="text" required />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input v-model="newClient.email" id="email" type="email" required />
          </div>
          <div class="form-group">
            <label for="phone">Phone</label>
            <input v-model="newClient.phone" id="phone" type="text" required />
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select v-model="newClient.status" id="status">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
          <div class="button-group">
            <button type="submit">Add Client</button>
            <!-- Cancel Button -->
            <button type="button" @click="closeModal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Add your styles here */
</style>
