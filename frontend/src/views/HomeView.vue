<template>
  <div class="container mx-auto">
    <h1 class="m-8 text-2xl">Contactos</h1>
 
    <div class="mt-3">
 
      <div class="grid grid-cols-12 gap-4">
        <div class="col-span-6 space-y-4 px-1"
             style="height: 500px">
          <div v-for="(contact, index) in state.contacts"
               :key="index"
               class="p-8 bg-white shadow-md rounded flex items-center justify-between"
               >
            <div>
              <div>Nombre: {{ contact.name }}</div>
              <div class="text-gray-500 text-sm">Teléfono: {{ contact.phone }}</div>
              <div class="text-gray-500 text-sm">Correo electrónico: {{ contact.email }}</div>
             
              <div class="text-gray-500 text-sm">Edad: {{ contact.year }}</div>
            </div>
            <div class="space-x-2">
              <button class="px-2 text-2xl text-red-600"
                      @click="removeContact(contact)"
                      title="Remover contacto"><font-awesome-icon icon="fa-solid fa-user-minus" />
</button>

                      <router-link :to="{ name: 'contact.update', params: { id: contact.id } }"><font-awesome-icon icon="fa-solid fa-pen-to-square" class="text-2xl" /></router-link>
                      
           
            </div>
          </div>
          <div v-if="state.contacts.length === 0"
               class="px-8 py-16 bg-white text-gray-700 shadow-md rounded text-sm">
            No tiene contactos
          </div>
        </div>

        <div class="col-span-6">
          <div class="p-8 bg-white shadow-md rounded">
            <h2 class="text-xl">Filtrar</h2>
            <div class="grid grid-cols-12 gap-4 ">
            <div class="col-span-11">
            <input type="text"
                   v-model="state.search"
                   @keydown.enter="filterContact()" placeholder="nombre, telefono o correo electrónico"
                   class="p-2 mt-4 mr-0 border rounded w-full">
            </div>
            <div class="col-span-1">
             
              <button v-if="state.search != ''" class="text-2xl mt-2 ml-0 pl-0 pt-2 text-red-800"
                      @click="getContacts()"
                      title="Limpiar filtro">&times;</button>
            </div> 
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { defineComponent, reactive } from "vue";


export default defineComponent({
  setup() {
    const state = reactive({
      contacts: [],
      search: "",
      showModal:true
    });
    
    function filterContact() {
      axios.post('http://127.0.0.1:8000/api/contact/search', {
        search: state.search
      }).then(response => {
        
        state.contacts= response.data.contacts;
      });
    }
  
    function removeContact(contact) {
      if (!confirm("¿Seguro que desea eliminar el contacto?")) {
        return;
      }
      axios.delete('http://127.0.0.1:8000/api/contact/'+contact.id).then(() => getContacts());
    }
    function getContacts() {
      axios.get('http://127.0.0.1:8000/api/contact')
        .then(response => {
          state.contacts = response.data.contacts;
          state.search="";
        });
    }
    getContacts();
    return {
      state,
      filterContact,
      getContacts,
      removeContact
    };
  }, 
 
	
  
});
</script>
