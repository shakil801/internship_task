// router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import Home from '../pages/Home.vue';
import Product from '../pages/Product.vue';
import Category from '../pages/Category.vue';
import EditProduct from '../pages/EditProduct.vue';
import Dashboard from '../pages/Dashboard.vue';

const routes = [
  {path: '/',
    name:'Home',
   component: Home },
  {path: '/product', name:'Product' ,component: Product},
  {path: '/category', name:'Category',component: Category},
  {
    path: '/edit-product/:id',
    name: 'edit-product',
    component: EditProduct,
    props: true
  },
  {path:'/dashboard',
    name:'dashboard',
    component : Dashboard,
    props:true
  },
  {
    path: '/edit-product/:id',
    name: 'EditProduct',
    component: EditProduct,
    props: true, // This allows passing the ID as a prop to the component
  },
 
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
