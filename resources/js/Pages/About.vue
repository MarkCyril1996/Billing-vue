<template>
  <div class="dashboard-container">
    <!-- Page Header Section -->
    <header class="page-header">
      <h1>About Us</h1>
      <p class="tagline">Simplifying billing and payment management</p>
    </header>

    <!-- About Section -->
    <section class="about-section">
      <div class="section-header">
        <h2>Welcome to Our Application</h2>
      </div>
      <div class="section-body">
        <p>
          Welcome to our application! We offer the best services to help you manage your billing and payments efficiently.
        </p>
        <p>
          Our mission is to simplify your financial management and provide a seamless experience for tracking billing records, client management, and payment statuses.
        </p>
      </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
      <div class="section-header">
        <h2>Our Team</h2>
      </div>
      <div class="team-members">
        <div class="team-member" v-for="member in teamMembers" :key="member.id">
          <img :src="member.image" :alt="member.name" class="team-member-image" />
          <h3>{{ member.name }}</h3>
          <p>{{ member.position }}</p>
        </div>
      </div>
    </section>
  </div>

  <div class="back-to-dashboard">
  <a href="/dashboard" class="btn-dashboard">Back to Dashboard</a>
</div>
</template>

<script setup>
import { ref } from 'vue';


// Team members data
const teamMembers = ref([
{
  id: 1,
  name: 'Patricia H. Virtudazo',
  position: 'CEO',
},
{
  id: 2,
  name: 'Earl Patrick James Gorrero',
  position: 'CTO',
 // Use a valid image path
},
{
  id: 3,
  name: 'Tricia Virtudazo',
  position: 'COO',
  
},
]);

// Using Vue Router to navigate back to the dashboard

const goBackToDashboard = () => {
router.push({ name: 'Dashboard' }); // Assuming the dashboard route is named 'Dashboard'
};
</script>

<style scoped>

.dashboard-container {
  padding: 30px;
  font-family: 'Roboto', Arial, sans-serif;
  background: url('/images/img1.png') no-repeat center center; /* Set img1.png as the background */
  background-size: cover; /* Ensure the image covers the entire container */
  max-width: 1200px; /* Limiting max width for better readability */
  margin: 0 auto; /* Centering the content */
  border-radius: 8px;
}

/* Page Header Styling */
.page-header {
  text-align: center;
  margin-bottom: 40px;
  background:  #a1c6e5;/* Header background color */
  color: white;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Added shadow for depth */
}

.page-header h1 {
  font-size: 3rem; /* Larger header */
  margin-bottom: 10px;
  font-weight: bold;
}

.page-header .tagline {
  font-size: 1.3rem;
  color: #f1f1f1; /* Light color for tagline */
}

/* Back to Dashboard Button Styling */
.back-to-dashboard {
  text-align: center;
  margin-top: 30px;
  margin-bottom: 30px;
}

.btn-dashboard {
  padding: 12px 25px;
  font-size: 1.2rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 50px; /* Rounded button */
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.3s ease;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-dashboard:hover {
  background-color: #0056b3;
  transform: translateY(-5px); /* Button elevation effect */
}

.btn-dashboard:active {
  background-color: #003d80; /* Darker color on active */
}

.btn-dashboard:focus {
  outline: none; /* Remove outline on focus */
  box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); /* Add blue glow */
}

/* Section Styling */
.about-section,
.team-section {
  margin-bottom: 40px;
  background: #ffffff; /* White background for sections */
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); /* Increased shadow for depth */
}

.section-header h2 {
  font-size: 2.2rem;
  color: white;
  margin-bottom: 20px;
  font-weight: bold;
  text-transform: uppercase; /* Makes the section headers stand out */
}

.section-body p {
  font-size: 1.2rem;
  line-height: 1.8;
  color: #555;
  margin-bottom: 20px;
}

/* Team Members Styling */
.team-members {
  display: flex;
  gap: 40px;
  justify-content: center; /* Centering the items */
  flex-wrap: wrap;
  padding: 30px 0;
  background-color:#5d81a79c;
  border-radius: 15px;
}

.team-member {
  text-align: center;
  width: 250px;
  padding: 20px;
  border-radius: 12px;
  background-color: #deeaef;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
  transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
  margin-bottom: 30px;
  overflow: hidden; /* To ensure content stays within bounds */
  border: 1px solid #e0e0e0; /* Light border to define each card */
}

.team-member:hover {
  transform: translateY(-15px); /* Slightly lift the card on hover */
  box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15); /* Deeper shadow for a 3D effect */
  background-color: #f8f8f8; /* Slightly darken the background on hover */
}

.team-member h3 {
  font-size: 1.4rem;
  color: #333;
  margin-top: 15px;
  font-weight: bold; /* Bold name for emphasis */
  transition: color 0.3s ease;
}

.team-member p {
  font-size: 1.1rem;
  color: #777;
  margin-top: 10px;
  transition: color 0.3s ease;
}

/* Hover effect for the name */
.team-member:hover h3 {
  color: #007bff; /* Change name color on hover */
}

/* Hover effect for the position */
.team-member:hover p {
  color: #007bff; /* Change position color on hover */
}

.team-member-image {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #ddd; /* Light border around the image */
  transition: transform 0.3s ease, border-color 0.3s ease;
}

.team-member-image:hover {
  transform: scale(1.1); /* Slight zoom effect on hover */
  border-color: #007bff; /* Blue border on hover */
}

/* Add background gradient to sections */
.about-section {
  background: linear-gradient(135deg, #73b6ed, #a8eeee); 
}

.team-section {
  background: linear-gradient(135deg, #b8c8cbb0, #cee0ff);

}

</style>
