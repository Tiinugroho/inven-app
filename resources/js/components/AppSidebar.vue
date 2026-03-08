<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { UserRound, FolderGit2, LayoutGrid, ShieldCheck, UserCog2 } from 'lucide-vue-next'
import AppLogo from '@/components/AppLogo.vue'
import NavFooter from '@/components/NavFooter.vue'
import NavRole from '@/components/NavRole.vue'
import NavDashboard from '@/components/NavDashboard.vue'
import NavUser from '@/components/NavUser.vue'
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar'
import { dashboard } from '@/routes'
import type { NavItem } from '@/types'

const page = usePage()

const mainNavItems: NavItem[] = [
{
    title: 'Dashboard',
    href: dashboard(),
    icon: LayoutGrid,
},
]

const mainNavRole: NavItem[] = [
{
    title: 'Pengguna',
    href: 'users',
    icon: UserRound,
},
{
    title: 'Role dan Hak Akses',
    href: 'roles',
    icon: UserCog2,
},
]

// fungsi cek menu aktif
const isActive = (url: string) => page.url.startsWith(url)
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavDashboard :items="mainNavItems" />
            <NavRole :items="mainNavRole" />
        </SidebarContent>


        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
