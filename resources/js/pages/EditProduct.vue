<template>
  <div class="max-w-lg mx-auto p-6 bg-green-100 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Edit Product</h2>

    <!-- Success Message -->
    <div v-if="successMessage" class="alert alert-success">
      {{ successMessage }}
    </div>

    <!-- Product Edit Form -->
    <form @submit.prevent="handleSubmit" enctype="multipart/form-data">
      <!-- Product Name -->
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
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
        <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
        <input
          type="file"
          id="image"
          @change="previewImage"
          ref="image"
          class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          accept="image/*"
        />
        <!-- Image Preview -->
        <div v-if="imagePreview" class="mt-2">
          <img :src="imagePreview" alt="Image Preview" class="h-32 w-32 object-cover rounded-md" />
        </div>
      </div>

      <!-- Submit Button -->
      <div class="mt-6">
        <button
          type="submit"
          class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Update Product
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'EditProduct',
   props: ['id'], // Receive the ID passed from the routes
  data() {
    return {
      productName: '',
      image: '',
      imagePreview: null,
      successMessage: '',
    };
  },
  mounted() {
    this.fetchProduct();
  },
  methods: {
    fetchProduct() {
      const productId = this.$route.params.id; // Get the product ID from the route parameters
      axios.get(`/products/${productId}/edit`)
        .then(response => {
          this.productName = response.data.name;
          this.imagePreview = response.data.image ? `/storage/${response.data.image}` : null;
        })
        .catch(error => {
          console.error('Error fetching product:', error);
        });
    },
    previewImage(event) {
      const file = event.target.files[0];
      if (file) {
        this.imagePreview = URL.createObjectURL(file);
      }
    },
    handleSubmit() {
      const productId = this.$route.params.id; // Get the product ID from the route parameters
      const formData = new FormData();
      formData.append('name', this.productName);
      formData.append('image', this.$refs.image.files[0]);

      axios.post(`/products/${productId}`, formData)
        .then(response => {
          this.successMessage = response.data.success || 'Product updated successfully!';
          this.$router.push('/dashboard');
        })
        .catch(error => {
          console.error('Error updating product:', error);
        });
    }
  }
}
</script>

<style scoped>
  *{
    font-size:18px;
    font-family: 'Poppins', sans-serif;
  }
  .alert-success {
    color: green;
    font-weight: bold;
  }
</style>
