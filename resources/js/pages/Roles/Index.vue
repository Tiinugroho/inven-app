<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import type { BreadcrumbItem } from '@/types';

const props = defineProps<{
    roles: Array<{
        id: number;
        name: string;
        permissions: Array<{ id: number; name: string }>;
    }>;
    permissions: Array<{ id: number; name: string }>;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Manajemen Role', href: '/roles' },
];

const showDeleteModal = ref(false);
const roleToDelete = ref<{ id: number; name: string } | null>(null);

const confirmDelete = (role: { id: number; name: string }) => {
    roleToDelete.value = role;
    showDeleteModal.value = true;
};

// Fungsi untuk menutup modal
const closeModal = () => {
    showDeleteModal.value = false;
    roleToDelete.value = null;
};

// Fungsi untuk mengeksekusi penghapusan via Inertia
const executeDelete = () => {
    if (roleToDelete.value) {
        router.delete(`/roles/${roleToDelete.value.id}`, {
            preserveScroll: true, // Agar halaman tidak scroll ke atas setelah dihapus
            onSuccess: () => {
                closeModal();
            },
        });
    }
};
</script>

<template>
    <Head title="Manajemen Role" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="relative flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Daftar Role & Hak Akses</h2>
                    <p class="text-muted-foreground text-sm mt-1">
                        Kelola jabatan karyawan dan tentukan fitur apa saja yang bisa mereka akses di sistem POS.
                    </p>
                </div>
                <Link href="/roles/create">
                    <Button size="sm" class="bg-primary text-primary-foreground">
                        + Tambah Role Baru
                    </Button>
                </Link>
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div 
                    v-for="role in roles" 
                    :key="role.id" 
                    class="flex flex-col rounded-xl border border-sidebar-border/70 p-6 shadow-sm bg-card"
                >
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-card-foreground">{{ role.name }}</h3>
                        
                        <div class="flex space-x-3">
                            <Link 
                                :href="`/roles/${role.id}/edit`" 
                                class="text-sm font-medium hover:underline transition-colors"
                            >
                                Edit
                            </Link>
                            
                            <button 
                                v-if="role.name !== 'Super Admin'"
                                @click="confirmDelete(role)"
                                class="text-sm font-medium text-red-600 hover:text-red-800 hover:underline transition-colors cursor-pointer"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>
                    
                    <p class="text-xs font-medium text-muted-foreground mb-3 uppercase tracking-wider">
                        Hak Akses (Permissions):
                    </p>
                    
                    <div class="flex flex-wrap gap-2 mt-auto">
                        <span 
                            v-for="perm in role.permissions" 
                            :key="perm.id"
                            class="inline-flex items-center rounded-md bg-secondary px-2 py-1 text-xs font-medium text-secondary-foreground ring-1 ring-inset ring-secondary/50"
                        >
                            {{ perm.name }}
                        </span>
                        
                        <span v-if="role.permissions.length === 0" class="text-sm text-muted-foreground italic">
                            Belum ada hak akses.
                        </span>
                    </div>
                </div>
            </div>
            
        </div>

        <div 
            v-if="showDeleteModal" 
            class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity"
        >
            <div class="w-full max-w-md transform overflow-hidden rounded-2xl bg-card p-6 text-left align-middle shadow-xl transition-all border border-border">
                
                <h3 class="text-lg font-bold leading-6 text-card-foreground">
                    Konfirmasi Hapus Role
                </h3>
                
                <div class="mt-3">
                    <p class="text-sm text-muted-foreground">
                        Apakah Anda yakin ingin menghapus role <span class="font-bold text-foreground">"{{ roleToDelete?.name }}"</span>? 
                        <br><br>
                        Tindakan ini tidak dapat dibatalkan dan karyawan dengan role ini mungkin akan kehilangan hak akses mereka.
                    </p>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <Button 
                        variant="outline" 
                        @click="closeModal"
                    >
                        Batal
                    </Button>
                    <Button 
                        @click="executeDelete"
                        class="bg-red-600 text-white hover:bg-red-700 focus:ring-red-500"
                    >
                        Ya, Hapus Role
                    </Button>
                </div>
            </div>
        </div>
        </AppLayout>
</template>