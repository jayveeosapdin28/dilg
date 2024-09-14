import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function useRole() {
    const page = usePage();

    const hasRole = (roleName) => {
        return computed(() => page.props.auth.user.role.indexOf(roleName) !== -1).value;
    };
    const isInRole = (roles) => {
        return Array.isArray(roles) ? computed(() => roles.includes(page.props.auth.user.role)).value : false;
    };

    return {
        hasRole,
        isInRole,
    };
}
