<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

import { Store } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <Head title="Log in" />

    <div class="w-full lg:grid lg:min-h-screen lg:grid-cols-2 xl:min-h-screen bg-background">
        
        <div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="mx-auto w-full max-w-[350px] space-y-6">
                
                <div class="flex flex-col space-y-2 text-center">
                    <div class="flex justify-center mb-4 lg:hidden">
                        <div class="flex h-10 w-10 items-center justify-center rounded-md bg-primary text-primary-foreground">
                            <Store class="h-6 w-6" />
                        </div>
                    </div>
                    <h1 class="text-3xl font-semibold tracking-tight">
                        Akses Sistem
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Masukkan Username/NIK dan password Anda untuk masuk ke terminal POS.
                    </p>
                </div>

                <div v-if="status" class="rounded-md bg-green-50 p-4 dark:bg-green-900/20">
                    <div class="text-sm font-medium text-green-600 dark:text-green-400">
                        {{ status }}
                    </div>
                </div>

                <Form 
                    v-bind="store.form()" 
                    :reset-on-success="['password']" 
                    v-slot="{ errors, processing }"
                    class="grid gap-6"
                >
                    <div class="grid gap-4">
                        <div class="grid gap-2">
                            <Label for="username">Username / NIK</Label>
                            <Input 
                                id="username" 
                                type="text" 
                                name="username" 
                                required 
                                autofocus 
                                :tabindex="1"
                                autocomplete="username" 
                                placeholder="Misal: KSR001" 
                                class="h-11"
                            />
                            <InputError :message="errors.username" />
                        </div>

                        <div class="grid gap-2">
                            <div class="flex items-center justify-between">
                                <Label for="password">Password</Label>
                                <TextLink v-if="canResetPassword" :href="request()" class="text-xs font-medium" :tabindex="5">
                                    Lupa password?
                                </TextLink>
                            </div>
                            <Input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                :tabindex="2"
                                autocomplete="current-password" 
                                placeholder="••••••••" 
                                class="h-11"
                            />
                            <InputError :message="errors.password" />
                        </div>

                        <div class="flex items-center space-x-2 mt-1">
                            <Checkbox id="remember" name="remember" :tabindex="3" />
                            <Label for="remember" class="text-sm font-normal leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Ingat saya di perangkat ini
                            </Label>
                        </div>

                        <Button 
                            type="submit" 
                            class="mt-2 h-11 w-full text-base font-medium" 
                            :tabindex="4" 
                            :disabled="processing"
                            data-test="login-button"
                        >
                            <Spinner v-if="processing" class="mr-2 h-4 w-4" />
                            Masuk
                        </Button>
                    </div>

                    <div class="mt-4 text-center text-sm text-muted-foreground" v-if="canRegister">
                        Belum memiliki akun karyawan?
                        <TextLink :href="register()" :tabindex="5" class="font-semibold text-primary hover:underline">
                            Daftar ke HRD
                        </TextLink>
                    </div>
                </Form>
            </div>
        </div>

        <div class="hidden lg:block relative bg-muted">
            <div class="absolute inset-0 bg-zinc-900 flex flex-col items-start justify-between p-10 text-white dark:bg-zinc-950">
                
                <div class="flex items-center text-lg font-medium">
                    <!-- <div class="flex h-10 w-10 items-center justify-center rounded-md bg-primary text-primary-foreground mr-3">
                        <Store class="h-6 w-6" />
                    </div> -->
                    Retail POS System
                </div>

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <p class="text-lg font-medium leading-relaxed">
                            "Sistem kasir dan inventori real-time terintegrasi untuk mendukung percepatan transaksi dan akurasi stok cabang secara presisi."
                        </p>
                        <footer class="text-sm text-zinc-400">Pusat Operasional</footer>
                    </blockquote>
                </div>
                
                <svg
                    class="absolute inset-0 h-full w-full opacity-10"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 100 100"
                    preserveAspectRatio="none"
                    stroke="currentColor"
                >
                    <path d="M0 100 L100 0" stroke-width="0.5" fill="none" />
                    <path d="M0 80 L100 -20" stroke-width="0.5" fill="none" />
                    <path d="M0 60 L100 -40" stroke-width="0.5" fill="none" />
                    <path d="M0 120 L100 20" stroke-width="0.5" fill="none" />
                </svg>
            </div>
        </div>

    </div>
</template>