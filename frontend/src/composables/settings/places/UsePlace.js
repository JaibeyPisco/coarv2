import axiosInstance from "@/lib/utils/axiosInstance";

import { showMessageNotification } from "@/lib/utils/Notification";

import { ref } from "vue";

export const UsePlace = () => {
    const loading = ref(false);
    const response = ref([]);

    const getPlaces = async () => {
        try {
            loading.value = true;
            const { data } = await axiosInstance.get('settings/places');
            console.log('Respuesta completa del backend:', data);
            
            // El backend devuelve { success: true, data: [...], message: "" }
            if (data.success && data.data) {
                response.value = data.data;
            } else {
                response.value = data; // Fallback
            }
            
            console.log('Roles cargados:', response.value);
        } catch (error) {
            console.error(error);
            const messages = error.response?.data?.data || ['Ocurrió un error inesperado'];
            showMessageNotification(messages, 'danger');
        } finally {
            loading.value = false;
        }
    };

    const deletePlace = async (roleId) => {
        try {
            loading.value = true;
            await axiosInstance.delete(`settings/role/${roleId}`);
            showMessageNotification('Rol eliminado correctamente', 'success');
            await getRoles(); // Recargar la lista
            return true;
        } catch (error) {
            console.error('Error al eliminar rol:', error);
            const messages = error.response?.data?.data || ['Error al eliminar el rol'];
            showMessageNotification(messages, 'danger');
            return false;
        } finally {
            loading.value = false;
        }
    };

    const refreshPlaces = async () => {
        try {
            // No mostrar loading para actualizaciones silenciosas
            const { data } = await axiosInstance.get('settings/places');
            console.log('Actualización silenciosa de roles:', data);
            
            if (data.success && data.data) {
                response.value = data.data;
            } else {
                response.value = data;
            }
            
            console.log('Roles actualizados:', response.value);
        } catch (error) {
            console.error('Error al actualizar roles:', error);
            // No mostrar notificación de error para actualizaciones silenciosas
        }
    };

    return {
        getPlaces,
        // deleteRole,
        refreshPlaces,
        response,
        loading
    };
};
 