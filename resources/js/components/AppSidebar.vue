<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { BookOpen, FolderGit2, LayoutGrid, ShieldCheck, UserCog2 } from 'lucide-vue-next'
import AppLogo from '@/components/AppLogo.vue'
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/components/NavMain.vue'
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

const mainNav2Items: NavItem[] = [
{
    title: 'Role',
    href: '/role',
    icon: UserCog2,
},
{
    title: 'Hak Akses',
    href: '/permission',
    icon: ShieldCheck,
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
            <NavMain :items="mainNav2Items" />
        </SidebarContent>


        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
