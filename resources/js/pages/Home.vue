<template>
  <div class="max-w-7xl mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Products</h2>

    <!-- Product Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 bg-gray-100 p-3">
      <div v-for="product in products" :key="product.id" class="bg-gray-500 shadow-md rounded-lg overflow-hidden">
        <!-- Product Image -->
        <img :src="'/storage/' + product.image" alt="Product Image" class="w-full h-48 object-cover p-4" />

        <div class="p-4">
          <!-- Product Name -->
          <h3 class="text-xl font-semibold text-white mb-4 text-center">{{ product.name }}</h3>

          <!-- Categories -->
          <div class="mb-2">
            <h6 class="text-md font-medium text-white mb-3">Categories</h6>
            <div class="flex flex-wrap gap-2">
              <span v-for="category in product.categories" :key="category.id" class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium">
                {{ category.name }}
              </span>
            </div>
          </div>

          <!-- Features -->
          <div class="mb-2">
            <h5 class="text-md font-medium text-gray-100 mb-2 mt-1">Features</h5>
            <ul class="list-disc pl-5 text-gray-600">
              <li v-for="feature in product.features" :key="feature.id" class="text-gray-100 mb-2">
                {{ feature.description }}
              </li>
            </ul>
          </div>

          <!-- Additional Information (Optional) -->
          <div v-if="product.additionalInfo" class="mt-4">
            <h4 class="text-lg font-medium text-gray-700 mb-1">Additional Information</h4>
            <p class="text-gray-600">
              {{ product.additionalInfo }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'HomePage',
  data() {
    return {
      products: []
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    fetchProducts() {
      axios.get('/products')
        .then(response => {
          this.products = response.data;
        })
        .catch(error => {
          console.error('Error fetching products:', error);
        });
    }
  }
}
</script>

<style scoped>

</style>
