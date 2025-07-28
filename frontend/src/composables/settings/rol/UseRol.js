import axiosInstance from "@/lib/utils/axiosInstance";

import { showMessageNotification } from "@/lib/utils/Notification";

import { ref } from "vue";

export const  UseRol = () => {
 
    const loading = ref(false);
    const response = ref([]);

    const getRoles = async()=>{
        
        try {
            loading.value = true;
            const {data} = await axiosInstance.get('settings/role');
            response.value = data;
                  
         

        } catch (error) {
            console.error(error);
            const messages = error.response?.data?.data || ['Ocurrió un error inesperado'];
            showMessageNotification(messages, 'danger');
            
        }finally{
            loading.value = false
        }
    }
    return {
        getRoles, response
    }
}
 