import {defineStore} from "pinia";
import api from "@/lib/utils/axiosInstance.js";

const API = import.meta.env.VITE_URL_BACKEND;


export  const useAuthStore = defineStore('authstore', {
  state: () => {
  return {
    user:null,
    initialData: null,
    errors: {}
  }
  },
  getters: () => {

  },
  actions: {
    async getInitialData(){

      try {
        const { data } = await api.post('/app/initial');


        this.initialData = data;

        // aquí puedes procesar `data`
      } catch (error) {
        console.error('Error al obtener datos iniciales:', error);
      }

    },
    authenticate: async function (formData) {

      const res = await fetch(`${API}api/login`, {
        method: "POST",

        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      })

      const data = await res.json();

      console.log(data)
      if (!data.success) {

        this.errors = data.data.errors
      } else {
        localStorage.setItem('token', data.data.token);
        this.router.push({name: 'home'})
      }

    }

  }
})
/*

export  default async  function (email, password){

  console.log(email, password)

  try {
    const  response = await fetch(`${API}/login`, {
      method:"POST",
      headers:{
        'Content-Type' :'application/json'
      },
      body:  JSON.stringify({
        email,
        password
      })
    })

    // Guardar token
    if (response.data.success) {
      localStorage.setItem('token', response.data.data.token);
      localStorage.setItem('user', JSON.stringify(response.data.data));
    }

    return response.data;

    //localStorage.setItem("token", data.data.token)

    return data;

  }catch (e) {
    return {
      success: false,
      message: error.response?.data?.message || 'Error al iniciar sesión.'
    };

  }


}
*/
