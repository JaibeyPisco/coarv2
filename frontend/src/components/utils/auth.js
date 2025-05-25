import axios from "axios";

export  async  function  isAthenticaded() {
    const token = localStorage.getItem("token");
    if(!token) return false;
    try {
        const res = await  axios.get(import.meta.env.VITE_BACKEND_API)
    }catch (e) {
        
    }
}