<script setup lang="ts">
    import {
        computed
    } from 'vue';
    import {
        Head,
        useForm,
        Link
    } from '@inertiajs/vue3';
    import AppLayout from '@/layouts/AppLayout.vue';
    import {
        Button
    } from '@/components/ui/button';
    import {
        Input
    } from '@/components/ui/input';
    import {
        Label
    } from '@/components/ui/label';
    import {
        Checkbox
    } from '@/components/ui/checkbox';
    import InputError from '@/components/InputError.vue';
    import type {
        BreadcrumbItem
    } from '@/types';

    const props = defineProps < {
        role: {
            id: number;
            name: string;
            permissions: Array < {
                id: number;name: string
            } > ;
        };
        permissions: Array < {
            id: number;name: string
        } > ;
    } > ();

    const breadcrumbs: BreadcrumbItem[] = [{
            title: 'Dashboard',
            href: '/dashboard'
        },
        {
            title: 'Manajemen Role',
            href: '/roles'
        },
        {
            title: 'Edit Role',
            href: `/roles/${props.role.id}/edit`
        },
    ];

    // Ambil array nama permission yang sudah dimiliki oleh role ini sebelumnya
    const existingPermissions = props.role.permissions.map(p => p.name);

    const form = useForm({
        name: props.role.name,
        permissions: existingPermissions,
    });

    // Grouping logic (Sama dengan Create.vue)
    const groupedPermissions = computed(() => {
        const groups: Record < string, Array < {
            id: number;name: string
        } >> = {
            'Manajemen POS & Transaksi': [],
            'Manajemen Inventori & Stok': [],
            'Manajemen Sistem & Karyawan': [],
            'Lainnya': [],
        };

        props.permissions.forEach(perm => {
            if (perm.name.includes('sale') || perm.name.includes('transaction')) groups[
                'Manajemen POS & Transaksi'].push(perm);
            else if (perm.name.includes('product') || perm.name.includes('stock') || perm.name.includes(
                    'opname')) groups['Manajemen Inventori & Stok'].push(perm);
            else if (perm.name.includes('user') || perm.name.includes('branch') || perm.name.includes(
                    'report')) groups['Manajemen Sistem & Karyawan'].push(perm);
            else groups['Lainnya'].push(perm);
        });

        return Object.fromEntries(Object.entries(groups).filter(([_, items]) => items.length > 0));
    });

    // const togglePermission = (permissionName: string, checked: boolean) => {
    //     if (checked) {
    //         form.permissions.push(permissionName);
    //     } else {
    //         form.permissions = form.permissions.filter(p => p !== permissionName);
    //     }
    // };

    const submit = () => {
        // Karena ini Update, gunakan method PUT
        form.put(`/roles/${props.role.id}`);
    };
</script>

<template>

    <Head :title="'Edit Role: ' + role.name" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-1 flex-col gap-6 p-4">

            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Edit Role: {{ role . name }}</h2>
                    <p class="text-muted-foreground text-sm mt-1">
                        Perbarui jabatan dan sesuaikan ulang hak akses yang dimilikinya.
                    </p>
                </div>
                <Link href="/roles">
                <Button variant="outline" size="sm">Kembali</Button>
                </Link>
            </div>

            <form @submit.prevent="submit" class="grid gap-8 lg:grid-cols-3">

                <div class="lg:col-span-1">
                    <div class="flex flex-col gap-4 rounded-xl border border-sidebar-border/70 p-6 bg-card shadow-sm">
                        <div class="grid gap-2">
                            <Label for="name" class="text-base font-semibold">Nama Role / Jabatan</Label>
                            <Input id="name" v-model="form.name" type="text" required
                                :disabled="role.name === 'Super Admin'" />
                            <InputError :message="form.errors.name" />
                            <p v-if="role.name === 'Super Admin'" class="text-xs text-red-500 mt-1">
                                Nama Super Admin tidak dapat diubah.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="flex flex-col rounded-xl border border-sidebar-border/70 p-6 bg-card shadow-sm">
                        <h3 class="text-base font-semibold mb-4 border-b pb-2">Pengaturan Hak Akses (Permissions)</h3>

                        <div class="grid gap-6 md:grid-cols-2">
                            <div v-for="(permissions, groupName) in groupedPermissions" :key="groupName"
                                class="space-y-3">
                                <h4 class="font-medium text-sm text-primary uppercase tracking-wider">
                                    {{ groupName }}</h4>

                                <div class="flex flex-col gap-3 ml-1">
                                    <div v-for="perm in permissions" :key="perm.id"
                                        class="flex items-start space-x-3">

                                        <input type="checkbox" :id="'perm-' + perm.id" :value="perm.name"
                                            v-model="form.permissions"
                                            class="mt-0.5 h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary cursor-pointer" />

                                        <div class="grid gap-1.5 leading-none">
                                            <Label :for="'perm-' + perm.id" class="text-sm font-normal cursor-pointer">
                                                {{ perm . name }}
                                            </Label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end border-t pt-4">
                            <Button type="submit" :disabled="form.processing" class="min-w-[120px]">
                                <span v-if="form.processing">Menyimpan...</span>
                                <span v-else>Perbarui Role</span>
                            </Button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </AppLayout>
</template>
