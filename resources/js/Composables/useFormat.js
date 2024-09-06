import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import dayjs from "dayjs";

export function useFormat() {

    const date = (date) => {
        return dayjs(date).format('MM/DD/YYYY')
    };

    return {
        date,

    };
}
