<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';
import { usePermission } from '@/composables/usePermission'; // Import composable yang baru dibuat
import { Button } from '@/components/ui/button'; // Menggunakan button dari komponen Anda

const page = usePage<any>();
const { hasRole, hasPermission } = usePermission();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
];

// Mengambil data user dan cabang dari props yang dikirim via HandleInertiaRequests
const user = page.props.auth.user;
const branch = page.props.auth.branch;
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 overflow-x-auto rounded-xl p-4">
            
            <div class="flex items-center justify-between rounded-xl border border-sidebar-border/70 p-6 bg-card text-card-foreground shadow-sm dark:border-sidebar-border">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Selamat Datang, {{ user.name }} !</h2>
                    <p class="text-muted-foreground mt-1">
                        Anda login sebagai <strong>{{ page.props.auth.roles[0] }}</strong> di cabang <strong>{{ branch?.name || 'Kantor Pusat' }}</strong>.
                    </p>
                </div>
                
                <!-- <div v-if="hasPermission('create sale')">
                    <Button size="lg" class="">
                        + Buka Kasir (POS)
                    </Button>
                </div> -->
            </div>

            <div v-if="hasRole('Manager') || hasRole('Super Admin')" class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="flex flex-col justify-center rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border shadow-sm">
                    <h3 class="text-sm font-medium text-muted-foreground">Total Penjualan Hari Ini</h3>
                    <p class="mt-2 text-3xl font-bold">Rp 0</p>
                    <p class="text-xs text-green-500 mt-1">+0% dari kemarin</p>
                </div>
                
                <div class="flex flex-col justify-center rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border shadow-sm bg-red-50/50 dark:bg-red-950/20">
                    <h3 class="text-sm font-medium text-red-600 dark:text-red-400">Peringatan Stok Tipis</h3>
                    <p class="mt-2 text-3xl font-bold text-red-700 dark:text-red-300">0 Item</p>
                    <p class="text-xs text-muted-foreground mt-1">Butuh restock segera</p>
                </div>
                
                <div class="flex flex-col justify-center rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border shadow-sm">
                    <h3 class="text-sm font-medium text-muted-foreground">Opname Pending</h3>
                    <div class="flex items-end justify-between mt-2">
                        <p class="text-3xl font-bold">0 Dokumen</p>
                        <Button v-if="hasPermission('approve opname')" variant="outline" size="sm">
                            Review
                        </Button>
                    </div>
                </div>
            </div>

            <div v-if="hasRole('Inventory Staff')" class="grid auto-rows-min gap-4 md:grid-cols-2">
                <div class="flex flex-col justify-center rounded-xl border border-sidebar-border/70 p-6 dark:border-sidebar-border shadow-sm">
                    <h3 class="text-sm font-medium text-muted-foreground">Tugas Hari Ini</h3>
                    <ul class="mt-4 space-y-2">
                        <li class="flex items-center text-sm"><span class="mr-2 h-2 w-2 rounded-full bg-blue-500"></span> Penerimaan Barang Supplier (PO-001)</li>
                        <li class="flex items-center text-sm"><span class="mr-2 h-2 w-2 rounded-full bg-yellow-500"></span> Opname Rak Minuman</li>
                    </ul>
                </div>
            </div>

            <div class="relative flex-1 rounded-xl border border-sidebar-border/70 p-6 md:min-h-[100] dark:border-sidebar-border shadow-sm">
                <h3 class="font-semibold mb-4">Aktivitas Terakhir Cabang {{ branch?.name || 'Pekanbaru' }}</h3>
                <div class="flex h-full items-center justify-center text-muted-foreground border-2 border-dashed rounded-lg border-sidebar-border/50">
                    <p>Tabel histori transaksi akan dimuat di sini...</p>
                </div>
            </div>
            
        </div>
    </AppLayout>
</template>