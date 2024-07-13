import { ref } from "vue";

const usePaginator = (data, meta) => {
    const getDisplayPageNumbers = (newMeta) => {
        const { current_page, last_page } = newMeta;

        let newPageNumbers;
        if (current_page === 1) {
            newPageNumbers =
                last_page >= 3
                    ? [1, 2, 3]
                    : Array.from({ length: last_page }, (_, index) => index + 1);
        } else if (current_page !== last_page) {
            newPageNumbers = [current_page - 1, current_page, current_page + 1];
        } else {
            newPageNumbers =
                last_page - 2 < 1
                    ? [current_page - 1, current_page]
                    : [current_page - 2, current_page - 1, current_page];
        }
        return newPageNumbers;
    };

    const refData = ref(data);
    const refMeta = ref(meta);
    const refDisplayPageNumbers = ref(getDisplayPageNumbers(refMeta.value));

    const updatePaginator = (newData, newMeta) => {
        refData.value = newData;
        refMeta.value = newMeta;
        refDisplayPageNumbers.value = getDisplayPageNumbers(newMeta);
    };

    return [refData, refMeta, refDisplayPageNumbers, updatePaginator];
};

export default usePaginator;
