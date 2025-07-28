import axiosInstance from "@/lib/utils/axiosInstance";
import { showMessageNotification } from "@/lib/utils/Notification";
import { ref } from "vue";

export const  Usesave = () => {
 
    const loading = ref(false);
    const response = ref([]);
    const save = async(formData)=>{
        
        try {
            loading.value = true;
            const {data} = await axiosInstance.post('settings/role/save', formData);
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
        save, loading, response
    }
}
 