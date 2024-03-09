import { ref } from "vue";

const useSelectChange = (defaultValue = null) => {
    const selected = ref(defaultValue);

    const handleChange = (newValue) => {
        selected.value = newValue;
    };

    return [selected, handleChange];
};

export default useSelectChange;
