<template>
    <aside :class="{ sidebar: true, 'sidebar--closed': !isSidebarOpen }">
        <p class="heading">Water Billing System</p>
        <ul class="menu">
            <div class="a">
                <h5>Main</h5>
            </div>
            <li>
              <a href="/clientlist">
                <img src="/images/img_img3.png" class="icon" />
                <span> List Of Clients</span>
              </a>
            </li>
            <li>
              <a href="/clientbilling">
                <img src="/images/img_img4.png" class="icon" />
                <span> Billings</span>
              </a>
            </li>
            <li>
              <a href="/monthlyreport">
                <img src="/images/img_img5.png" class="icon" />
                <span> Monthly Report</span>
              </a>
            </li>
            <div class="a">
                <h5>Maintenance</h5>
            </div>
            <li>
              <a href="/about">
                <img src="/images/img_img7.png" class="icon" />
                <span> About</span>
              </a>
            </li>
        </ul>
    </aside>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  // Toggle sidebar state
  const isSidebarOpen = ref(true);
  </script>
  
  <style src="/resources/css/sidebar.css"></style>
  