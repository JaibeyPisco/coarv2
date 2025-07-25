import axios from "axios";

 const API_BASE_URL = import.meta.env.VITE_BACKEND_API;

 const axiosInstance = axios.create({
     baseUrl:API_BASE_URL,
     headers: {
         'Content-Type': "application/json"
     }
 })

axiosInstance.interceptors.request.use(config => {
    const token = localStorage.getItem("token");

    if(token){
        config.headers.Authorization =  `Bearear ${token}`
    }

    return config;
}, error => {
    return Promise.reject(error)
})


export  default  axiosInstance;
