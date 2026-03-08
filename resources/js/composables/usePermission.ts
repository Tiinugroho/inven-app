// resources/js/composables/usePermission.ts
import { usePage } from '@inertiajs/vue3';

export function usePermission() {
    const page = usePage<any>(); // Gunakan <any> atau sesuaikan dengan interface PageProps Anda

    // Cek apakah user memiliki permission tertentu
    const hasPermission = (permissionName: string): boolean => {
        const permissions = page.props.auth?.permissions || [];
        return permissions.includes(permissionName);
    };

    // Cek apakah user memiliki role tertentu
    const hasRole = (roleName: string): boolean => {
        const roles = page.props.auth?.roles || [];
        return roles.includes(roleName);
    };

    // Cek jika user memiliki setidaknya satu dari beberapa permission
    const hasAnyPermission = (permissionNames: string[]): boolean => {
        const permissions = page.props.auth?.permissions || [];
        return permissionNames.some((p) => permissions.includes(p));
    };

    return {
        hasPermission,
        hasRole,
        hasAnyPermission,
    };
}