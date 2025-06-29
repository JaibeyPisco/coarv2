import axiosInstance from "@/lib/utils/axiosInstance";

export  default async (formData) => {
    try {
        const data = (await axiosInstance.post('/user/save', JSON.stringify(formData)) );
        console.log(data);
        
    } catch (error) {
        console.log(error);
        
    }
}