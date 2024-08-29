<template>
  <div>
    <h1 class="text-semibold text-lg mb-3">Product Dashboard</h1>
    <table>
      <thead>
        <tr class="bg-green-300">
          <th>ID</th>
          <th>Name</th>
          <th>Image</th>
          <th>Categories</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>
            <img :src="'/storage/' + product.image" :alt="product.name" width="50"/>
          </td>
          <td>
            <ul>
              <li v-for="category in product.categories" :key="category.id">
                {{ category.name }}
              </li>
            </ul>
          </td>
          <td>
            <button @click="editProduct(product.id)" class="text-blue-600 bg-gray-200 p-1 rounded-sm mx-2">Edit</button>
            <button @click="deleteProduct(product.id)" class="text-red-500">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name:'Dashboard',
  data() {
    return {
      products: [],
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    fetchProducts() {
      axios.get('/dashboard')
        .then(response => {
          this.products = response.data;
        })
        .catch(error => {
          console.error("There was an error fetching the products!", error);
        });
    },
    editProduct(productId) {

      //alert(`Edit product with ID: ${productId}`);
      // Example: this.$router.push(`/edit-product/${productId}`);
      this.$router.push({ name: 'EditProduct', params: { id: productId } });
    },
    deleteProduct(productId) {
      if (confirm("Are you sure you want to delete this product?")) {
        axios.delete(`/delete-products/${productId}`)
          .then(response => {
            this.fetchProducts(); // Refresh the product list after deletion
            alert("Product deleted successfully!");
          })
          .catch(error => {
            console.error("There was an error deleting the product!", error);
          });
      }
    },
  },
};
</script>

<style scoped>
  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    padding: 8px 12px;
    border: 1px solid #ddd;
  }
  img {
    max-width: 50px;
    height: auto;
  }
  button {
    margin-right: 5px;
  }
</style>
