<template>
  <div class="max-w-lg mx-auto p-6 bg-green-100 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Add New Product</h2>
    
    <div v-if="successMessage" class="alert alert-success py-3">
      {{ successMessage }}
    </div>

    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
      <!-- Product Name -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-3">Product Name</label>
        <input
          type="text"
          id="name"
          v-model="productName"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          required
        />
      </div>

      <!-- Product Image -->
      <div class="mb-4">
        <label for="image" class="block text-sm font-medium text-gray-700 mb-3">Product Image</label>
        <input
          type="file"
          id="image"
          @change="previewImage"
          ref="image"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          accept="image/*"
          required
        />
        <div v-if="imagePreview" class="mt-2">
          <img :src="imagePreview" alt="Image Preview" class="h-32 w-32 object-cover rounded-md" />
        </div>
      </div>

      <!-- Categories -->
      <div class="mb-4">
        <label for="categories" class="block text-sm font-medium text-gray-700 mb-3">Categories</label>
        <select
          id="categories"
          v-model="selectedCategories"
          multiple
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        >
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <!-- Dynamic Feature Fields -->
      <div v-for="(feature, index) in features" :key="index" class="mb-4">
        <label :for="'feature' + index" class="block text-sm font-medium text-gray-700 mb-3">Feature {{ index + 1 }}</label>
        <input
          type="text"
          :id="'feature' + index"
          v-model="features[index]"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
        />
      </div>

      <!-- Add More Button -->
      <div class="mb-4">
        <button
          type="button"
          @click="addFeature"
          class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600"
        >
          Add More
        </button>
      </div>

      <!-- Submit Button -->
      <div class="mt-6">
        <button
          type="submit"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Upload Product
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      productName: '',
      imagePreview: null,
      selectedCategories: [],
      categories: [],
      successMessage: '',
      features: [''], // Initialize with one empty feature input
    };
  },
  mounted() {
    this.fetchCategories();
  },
  methods: {
    fetchCategories() {
      axios.get('/categories')
        .then(response => {
          if (response.data.success) {
            this.categories = response.data.data;
          } else {
            console.error('Failed to fetch categories');
          }
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.imagePreview = URL.createObjectURL(file);
      }
    },
    addFeature() {
      this.features.push(''); // Add an empty string to the features array
    },
    handleSubmit() {
      const formData = new FormData();
      formData.append('name', this.productName);
      formData.append('image', this.$refs.image.files[0]);

      // Append each category separately
      this.selectedCategories.forEach((category, index) => {
        formData.append(`categories[${index}]`, category);
      });

      // Append each feature
      this.features.forEach((feature, index) => {
        formData.append(`features[${index}]`, feature);
      });

      axios.post('/products', formData)
        .then(response => {
          console.log('Product uploaded successfully:', response.data);
          this.successMessage = response.data.message || 'Product uploaded successfully!';
          
          // Reset form fields
          this.productName = '';
          this.$refs.image.value = null;
          this.imagePreview = null;
          this.selectedCategories = [];
          this.features = ['']; // Reset features array
        })
        .catch(error => {
          console.error('Error uploading product:', error);
        });
    },
  },
};
</script>

<style scoped>
    *{
      font-size:16px;
      font-family: 'Poppins', sans-serif;
    }
    .alert-success {
      color: green;
      font-weight: bold;
    }
</style>
