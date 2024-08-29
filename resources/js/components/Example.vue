<template>
<nav>
    <router-link to="/">Home</router-link>
    <router-link to="/about">About</router-link>
  </nav>
<div  class="container mx-auto p-3 greetings sm:p-6">
<h1 class="text-3xl text-gray-600 capitalize">{{message}}</h1>
<button class="bg-green-500 p-2 mt-3 focus:outline-none rounded text-white text-semibold text-lg" @click="changeMessage">Say Thanks</button>
</div>
</template>

<script>
export default{
    data(){
        return{
            message:'hello world'
        }
    },
    methods:{
        changeMessage(){
            this.message = 'You click the button';
        }
    }
}
</script>

<style scoped>
.greetings {
    font-family: 'Times New Roman', 'Serif';
}
</style>