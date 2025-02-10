<template>
  <div class="dashboard">
    <Sidebar />

    <div class="client-list-container">
      <header class="header">
        <h2>Client List</h2>
        <button class="add-client-button" @click="openAddClientForm">Add Client</button>
      </header>

      <div class="client-list">
        <table>
          <thead>
            <tr>
              <th>Client ID</th>
              <th>Name</th>
              <th>Address</th>
              <th>Meter Code</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="client in clients" :key="client.id">
              <td>{{ client.id }}</td>
              <td>{{ client.name }}</td>
              <td>{{ client.address }}</td>
              <td>{{ client.meter_code }}</td>
              <td>{{ client.email }}</td>
              <td>{{ client.phone_number }}</td>
              <td :class="{'status-inactive': client.status === 'Inactive', 'status-active': client.status === 'Active'}">
                {{ client.status }}
              </td>
              <td>
                <button @click="openEditClientForm(client)" class="edit-button">Edit</button>
                <button @click="deleteClient(client.id)" class="delete-button">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <a href="/dashboard" class="back-to-dashboard-link">Back to Dashboard</a>
    </div>

    <!-- Add/Edit Client Modal -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close-button" @click="closeModal">&times;</span>
        <h2>{{ isEditing ? 'Edit Client' : 'Add New Client' }}</h2>
        <form @submit.prevent="isEditing ? updateClient() : addClient()">
          <div class="form-group">
            <label for="name">Name</label>
            <input v-model="currentClient.name" id="name" type="text" required />
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input v-model="currentClient.address" id="address" type="text" required />
          </div>
          <div class="form-group">
            <label for="meter_code">Meter Code</label>
            <input v-model="currentClient.meter_code" id="meter_code" type="text" required />
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input v-model="currentClient.email" id="email" type="email" required />
          </div>
          <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input v-model="currentClient.phone_number" id="phone_number" type="text" required />
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <select v-model="currentClient.status" id="status">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
          <div class="button-group">
            <button type="submit" :disabled="isLoading">{{ isEditing ? 'Update Client' : 'Add Client' }}</button>
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

const clients = ref([]);
const showModal = ref(false);
const isEditing = ref(false); // Flag for edit mode
const isLoading = ref(false);
const currentClient = ref({
  id: null,
  name: '',
  address: '',
  meter_code: '',
  email: '',
  phone_number: '',
  status: 'Active',
});

// Open modal for adding a new client
const openAddClientForm = () => {
  isEditing.value = false;
  currentClient.value = { id: null, name: '', address: '', meter_code: '', email: '', phone_number: '', status: 'Active' };
  showModal.value = true;
};

// Open modal for editing an existing client
const openEditClientForm = (client) => {
  isEditing.value = true;
  currentClient.value = { ...client }; // Copy the client data into the form
  showModal.value = true;
};

// Close the modal and reset form
const closeModal = () => {
  showModal.value = false;
  currentClient.value = { id: null, name: '', address: '', meter_code: '', email: '', phone_number: '', status: 'Active' };
};

// Add a new client
const addClient = async () => {
  if (!currentClient.value.name || !currentClient.value.address || !currentClient.value.meter_code || !currentClient.value.email || !currentClient.value.phone_number) {
    alert("Please fill out all fields.");
    return;
  }

  isLoading.value = true;

  try {
    const response = await axios.post('/clients', currentClient.value);

    if (response.data) {
      clients.value.push(response.data); // Add the newly added client to the list
      closeModal(); // Close the modal
    } else {
      console.error("Unexpected response structure:", response);
    }
  } catch (error) {
    isLoading.value = false;
    const errorMessage = error.response
      ? error.response.data.message || error.message
      : error.message;
    console.error('Error adding client:', errorMessage);
    alert(`There was an error adding the client: ${errorMessage}`);
  }
};

// Update client details
const updateClient = async () => {
  if (!currentClient.value.name || !currentClient.value.address || !currentClient.value.meter_code || !currentClient.value.email || !currentClient.value.phone_number) {
    alert("Please fill out all fields.");
    return;
  }

  isLoading.value = true;

  try {
    const response = await axios.put(`/clients/${currentClient.value.id}`, currentClient.value);

    if (response.data) {
      // Update the client in the list with the updated data
      const index = clients.value.findIndex(client => client.id === currentClient.value.id);
      if (index !== -1) {
        clients.value[index] = response.data;
      }
      closeModal(); // Close the modal
    }
  } catch (error) {
    isLoading.value = false;
    const errorMessage = error.response
      ? error.response.data.message || error.message
      : error.message;
    console.error('Error updating client:', errorMessage);
    alert(`There was an error updating the client: ${errorMessage}`);
  }
};

// Delete client
const deleteClient = async (clientId) => {
  if (confirm("Are you sure you want to delete this client?")) {
    isLoading.value = true;
    try {
      const response = await axios.delete(`/clients/${clientId}`);

      if (response.status === 200) {
        clients.value = clients.value.filter(client => client.id !== clientId);
        alert("Client deleted successfully.");
      } else {
        alert("Failed to delete the client.");
      }
    } catch (error) {
      isLoading.value = false;
      const errorMessage = error.response
        ? error.response.data.message || error.message
        : error.message;
      console.error('Error deleting client:', errorMessage);
      alert(`There was an error deleting the client: ${errorMessage}`);
    }
  }
};

// Fetch clients when the component is mounted
onMounted(async () => {
  try {
    const response = await axios.get('/clients');
    clients.value = response.data;
  } catch (error) {
    const errorMessage = error.response
      ? error.response.data.message || error.message
      : error.message;
    console.error('Error fetching clients:', errorMessage);
  }
});
</script>

<style src="/resources/css/client.css"></style>
