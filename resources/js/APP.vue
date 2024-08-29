<template>
  <div class="container mx-auto p-8">
    <div id="app">
      <!-- Navigation Menu -->
      <nav class="bg-green-700 shadow-sm p-4 mb-8 text-white rounded-md">
        <ul class="flex space-x-4">
          <li>
            <router-link
              :to="{ name: 'Home' }"
              class="text-gray-200 hover:text-gray-300 font-medium"
              active-class="text-yellow-300"
            >
              Home
            </router-link>
          </li>
          <li>
            <router-link
              :to="{ name: 'Product' }"
              class="text-gray-200 hover:text-gray-300 font-medium"
              active-class="text-yellow-300"
            >
              Add Product
            </router-link>
          </li>
          <li>
            <router-link
              :to="{ name: 'Category' }"
              class="text-gray-200 hover:text-gray-300 font-medium"
              active-class="text-yellow-300"
            >
              View Category
            </router-link>
          </li>


    <li>
    <router-link :to="{name:'dashboard'}" class="text-gray-300 hover:text-gray-200 font-medium" active-class="text-yellow-300">
      Dashboard
    </router-link>
    </li>
        </ul>
      </nav>

      <!-- Main Content -->
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  name: "App",
};
</script>

<style scoped>
/* Tailwind CSS does most of the styling, but you can add more here if needed */

  *{
    font-size:16px;
    font-family: 'Poppins', sans-serif;
  }

</style>
