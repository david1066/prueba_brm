<template>
  
  <nav  class="bg-purple-600 text-white">
    <div class="container mx-auto">

      <div class="flex items-center">

      
        <router-link to ="/"  class="inline-block px-16 py-4 transition-colors hover:bg-purple-500 duration-300 text-3xl"><font-awesome-icon icon="fa-solid fa-house-user" /></router-link>
        <a href="/contact/create" class="inline-block px-16 py-4 transition-colors hover:bg-purple-500 duration-300 text-3xl"><font-awesome-icon icon="fa-solid fa-user-plus" /></a>
      </div>
    </div>
  </nav>
  <router-view/>

</template>



