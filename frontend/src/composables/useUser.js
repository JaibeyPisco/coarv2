import axiosInstance from "@/lib/utils/axiosInstance";
import { ref } from "vue"

export function useUser ()  {
    const users = ref([])
    const loading = ref(false)

    const getUsers = async () => {
        try {
            loading.value = true
            const { data } = await axiosInstance.get('settings/users')
    
            if(data.success){
                users.value = data.data;
            }
        } catch (error) {
            console.error(error);
        } finally {
            loading.value = false
        }
    }
    


    return {
        users, getUsers, loading
    }
}