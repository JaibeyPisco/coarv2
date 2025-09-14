import axiosInstance from '@/lib/utils/axiosInstance'
import {ref} from 'vue';

const baseUrl = 'settings/company';

export const UseCompany = () =>{
	const loading = ref(false);
	const response = ref([]);

	const getCompany = async () => {
		try {
			loading.value = true;
			const {data} = await axiosInstance.get(baseUrl);	
               console.log(data);

			   response.value = data;

			loading.value = false;
			return data;
		} catch(error) {
			loading.value = false;
			console.log(error);
			throw error;
		}
	}

	const save = async (formData) => {
		try {
			loading.value = true;
			const {data} = await axiosInstance.post('/settings/company/save', formData);
			loading.value = false;
			return data;
		} catch(error) {
			loading.value = false;
			console.log(error);
			throw error;
		}
	}

	return {
		loading,
		response,
		getCompany,
		save
	}
}

