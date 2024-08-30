<template>
  <div class="mb-4">
    <div class="flex justify-between items-center mb-2">
    <h2 class="text-lg font-medium text-gray-700 mb-4">Categories</h2>
    <button @click="openModal"  class="p-2 bg-red-400 text-semibold rounded text-white" >Add Category</button>
    </div>

    <!-- Categories Table -->
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr class="text-lg">
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-lg">
            ID
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-lg">
            Name
          </th>
          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-lg">
            Actions
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <tr v-for="category in categories" :key="category.id">
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-lg">{{ category.id }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-lg">{{ category.name }}</td>
          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <button 
              @click="deleteCategory(category.id)"
              class="text-red-600 hover:text-red-900 font-lg"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h3 class="text-xl font-semibold mb-4">Add New Category</h3>
        <form @submit.prevent="submitCategory">
        <input type="text" v-model="categoryName" placeholder="Category Name" class="w-full p-2 border rounded mb-4">
        <div class="flex justify-end">
          <button @click="closeModal" class="p-2 bg-gray-300 rounded mr-2">Cancel</button>
          <button class="p-2 bg-blue-500 text-white rounded">Save</button>
        </div>
         </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      categories: [],  // To store the fetched categories
      isModalOpen: false,
      categoryName: '',
    };
  },
  methods: {
    // Fetch categories from the server
    fetchCategories() {
      axios.get('/categories')
        .then(response => {
          if (response.data.success) {
            this.categories = response.data.data; // Update the categories array
          } else {
            console.error('Failed to fetch categories');
          }
        })
        .catch(error => {
          console.error('Error fetching categories:', error);
        });
    },
    // Delete a category
    deleteCategory(categoryId) {
      if (confirm('Are you sure you want to delete this category?')) {
        axios.delete(`/categories/${categoryId}`)
          .then(response => {
            if (response.data.success) {
              // Remove the deleted category from the categories array
              this.categories = this.categories.filter(category => category.id !== categoryId);
            } else {
              console.error('Failed to delete category');
            }
          })
          .catch(error => {
            console.error('Error deleting category:', error);
          });
      }
    },
    openModal(){
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.categoryName = ''; // Clear the input field
    },
    async submitCategory(){
      try{
        await axios.post('/categories',{name : this.categoryName});
        this.closeModal();
      }
      catch (error) {
        console.error('There was an error saving the category:', error);
      }
    },
  },
  mounted() {
    // Fetch categories when the component is mounted
    this.fetchCategories();
  }
};
</script>

<style scoped>
  *{
    font-size:18px;
    font-family: 'Poppins', sans-serif;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  th, td {
    padding: 10px;
    text-align: left;
  }
  th {
    background-color: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
  }
  td {
    border-bottom: 1px solid #e5e7eb;
  }
</style>
