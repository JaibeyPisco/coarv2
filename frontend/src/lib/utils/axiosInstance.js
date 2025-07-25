import axios from "axios";

 const API_BASE_URL = import.meta.env.VITE_URL_BACKEND;

 const axiosInstance = axios.create({
     baseURL:API_BASE_URL + 'api/',
    //  headers: {
    //      'Content-Type': "application/json"
    //  }
 })

axiosInstance.interceptors.request.use(config => {
    const token = localStorage.getItem("token");

    if(token){

      config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
}, error => {
    return Promise.reject(error)
})


export  default  axiosInstance;
