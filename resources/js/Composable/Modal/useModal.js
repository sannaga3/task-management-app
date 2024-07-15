import { ref } from "vue";

const useModal = () => {
    const isOpenModal = ref(false);
    const modalItem = ref(null);

    const openModal = (item = null) => {
        if (item) modalItem.value = item;
        isOpenModal.value = true;
    };

    const closeModal = () => {
        modalItem.value = null;
        isOpenModal.value = false;
    };

    return [isOpenModal, openModal, closeModal, modalItem];
};

export default useModal;
