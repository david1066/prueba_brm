<template>
  <div class="container mx-auto">
    <h1 class="m-8 text-2xl">Agregar Contacto <font-awesome-icon icon="fa-solid fa-user-plus" /></h1>
 
    <div class="mt-3">
      
 
      <div class="grid grid-cols-12 ">
        <div  v-if="state.status=='danger'" class="mt-4 pt-4 col-span-12 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
          <strong class="font-bold">Error al guardarlo</strong>
          
        </div>

        <div v-if="state.status=='success'" class="mt-4 pt-4 col-span-12 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
          <strong class="font-bold">Gurdado con exito</strong>
          
        </div>
     
        <div class="col-span-12 ">
            <div class="p-8 bg-white shadow-md ">
       
              <div class="grid grid-cols-12 ">
                <div class="col-span-2 ">
                  <div  class="w-full mt-4 p-2">Nombre </div>
                
                </div> 
                
                <div class="col-span-10">
                    <input type="text"
                      v-model="state.contact.name"
                      :disabled="id"
                      placeholder="Nombre"
                      class="p-2 mt-4 mr-0 border rounded w-full">
                      <span :class="{'text-red-800':state.errorcontact.name!=''}">{{state.errorcontact.name.toString()}}</span>
                </div>
              </div>
          </div>
        </div>
        <div class="col-span-12">
            <div class="p-8 bg-white shadow-md ">
       
              <div class="grid grid-cols-12">
                <div class="col-span-2 ">
                  <div class="w-full mt-1 p-2">Teléfono</div>
                
                </div> 
                
                <div class="col-span-10">
                    <input type="text"
                      v-model="state.contact.phone"
                       placeholder="Teléfono"
                      class="p-2 mt-1 mr-0 border rounded w-full">
                      <span :class="{'text-red-800':state.errorcontact.phone!=''}">{{state.errorcontact.phone.toString()}}</span>
                </div>
              </div>
            </div>
        </div>
        <div class="col-span-12">
            <div class="p-8 bg-white shadow-md ">
       
              <div class="grid grid-cols-12">
                <div class="col-span-2 ">
                  <div class="w-full mt-1 p-2">Fecha nacimiento</div>
                
                </div> 
                
                <div class="col-span-10">
                    <input type="date"  :disabled="id"
                      v-model="state.contact.date_birth"
                      placeholder="Fecha nacimiento"
                      class="p-2 mt-1 mr-0 border rounded w-full">
                      <span :class="{'text-red-800':state.errorcontact.date_birth!=''}">{{state.errorcontact.date_birth.toString()}}</span>
                </div>
              </div>
            </div>
        </div>


        <div class="col-span-12">
            <div class="p-8 bg-white shadow-md ">
       
              <div class="grid grid-cols-12">
                <div class="col-span-2 ">
                  <div class="w-full mt-1 p-2">Dirección</div>
                
                </div> 
                
                <div class="col-span-10">
                    <input type="text"
                      v-model="state.contact.address"
                      placeholder="Dirección"
                      class="p-2 mt-1 mr-0 border rounded w-full">
                      <span :class="{'text-red-800':state.errorcontact.address!=''}">{{state.errorcontact.address.toString()}}</span>
                </div>
              </div>
            </div>
        </div>
        <div class="col-span-12">
            <div class="p-8 bg-white shadow-md ">
       
              <div class="grid grid-cols-12">
                <div class="col-span-2 ">
                  <div class="w-full mt-1 p-2">Correo electrónico</div>
                
                </div> 
                
                <div class="col-span-10">
                    <input type="text"
                      v-model="state.contact.email"
                      placeholder="Correo electrónico"
                      class="p-2 mt-1 mr-0 border rounded w-full">
                      <span :class="{'text-red-800':state.errorcontact.email!=''}">{{state.errorcontact.email.toString()}}</span>
                </div>
              </div>
            </div>
        </div>
        <div class="col-span-12">
            <div class="p-8 bg-white shadow-md ">
       
              <div class="grid grid-cols-12 ">
                <div class="col-span-5"></div>
                 
               <button v-if="!id" class="col-span-2 p-1  ring-4 bg-green-300 text-center sm:text-center  text-white rounded ring-green-300 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50 "
                      @click="createContact()"
                      title="Crear contacto">Guardar</button>
                <button v-if="id" class="col-span-2 p-1  ring-4 bg-green-300 text-center sm:text-center  text-white rounded ring-green-300 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50 "
                @click="updateContact(id)"
                title="Crear contacto">Guardar </button>
                <div class="col-span-4"></div> 
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
      contact: {name:'',phone:'',date_birth:'',address:'', email:''},
      errorcontact: {name:'',phone:'',date_birth:'',address:'', email:''},
      status:''
    });
   
    function createContact() {
      state.errorcontact.name='';
      state.errorcontact.phone='';
      state.errorcontact.date_birth='';
      state.errorcontact.address='';
      state.errorcontact.email='';
      axios.post('http://127.0.0.1:8000/api/contact', {
        name: state.contact.name,
        phone: state.contact.phone,
        date_birth: state.contact.date_birth,
        address: state.contact.address,
        email: state.contact.email,
      }).then(response => {
        
        if(response.data.status=='success'){
          state.status='success';
        }else{
          state.status='danger';
        }

      }).catch(function (error) {
        state.status='danger';
        

        if(error.response.data.errors.name){
          state.errorcontact.name= error.response.data.errors.name[0];
        }
        if(error.response.data.errors.phone){
          state.errorcontact.phone= error.response.data.errors.phone[0];
        }
        if(error.response.data.errors.date_birth){
          state.errorcontact.date_birth= error.response.data.errors.date_birth[0];
        }
        if(error.response.data.errors.address){
          state.errorcontact.address= error.response.data.errors.address[0];
        }
        if(error.response.data.errors.email){
          state.errorcontact.email= error.response.data.errors.email[0];
        }
       
      });

    }
    function updateContact(id) {
      state.errorcontact.name='';
      state.errorcontact.phone='';
      state.errorcontact.date_birth='';
      state.errorcontact.address='';
      state.errorcontact.email='';
      axios.put('http://127.0.0.1:8000/api/contact/'+id, {
        phone: state.contact.phone,
        address: state.contact.address,
        email: state.contact.email,
      }).then(response => {
        
        if(response.data.status=='success'){
          state.status='success';
        }else{
          state.status='danger';
        }

      }).catch(function (error) {
        state.status='danger';
        
        if(error.response.data.errors.phone){
          state.errorcontact.phone= error.response.data.errors.phone[0];
        }
       
        if(error.response.data.errors.address){
          state.errorcontact.address= error.response.data.errors.address[0];
        }
        if(error.response.data.errors.email){
          state.errorcontact.email= error.response.data.errors.email[0];
        }
        
      });

    }
    
    return {
      state,
      createContact,
      updateContact
    };
  }, data(){

  

    function getContact(id,state) {
     
      axios.get('http://127.0.0.1:8000/api/contact/'+id)
        .then(response => {
          state.contact = response.data.contact; 
         
        });
    }
    let id=this.$route.params.id;
    if(id){
      getContact(id,this.state);
    }else{
      id=undefined;
    }
   


   
    return{
      id
      
    };
  }
 
	
  
});
</script>
