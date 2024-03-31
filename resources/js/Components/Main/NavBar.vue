<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-image: linear-gradient(to right, rgb(198, 170, 250) , rgb(221, 221, 221)) ;">
    <div class="container-fluid">
      <span class="navbar-text h3 fw-bold" style="font-weight: bold; color: black; font-size: 25px;" >Student Dashboard</span>

      <div class="ml-auto">
        <ul class="navbar-nav">
          <li class="nav-item">
            <Link :href="route('profile.edit')" class="nav-link link-success fw-bold" style="font-weight: bold; color: black;" >Update Profile</Link>
          </li>
          <li class="nav-item">
            <Link :href="route('logout')" class="nav-link link-success fw-bold" method="post" style="font-weight: bold; color: black;">Log-out</Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
  components: {
    Link
  }
};
</script>

<style scoped>


.navbar-brand {
  font-size: 24px;
}

.nav-link {
  font-size: 16px;
  margin-left: 15px;
  background-color: rgb(154, 94, 195);
  margin: 4px;
  padding: 5px;
  border: 2px;
  border-color: black;
  border-radius: 5px;
  

}

.nav-link:hover {
  background-color: rgba(47, 9, 9, 0.1);
}

</style>
