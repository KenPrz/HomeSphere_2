<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import TopNav from "@/Layouts/TopNav.vue";
import SideNav from "@/Layouts/SideNav.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import ImageContainer from "@/Components/ImageContainer.vue";
import SideNavLink from "@/Components/SideNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>
<template>
    <div class="grid grid-cols-1 min-h-screen">
        <!-- Navbar -->
            <TopNav/>
        <!-- End Navbar -->
        <div class="md:flex">
            <!-- Sidebar -->
            <SideNav/>
            <!-- End Sidebar -->
            <!-- Main Content -->
            <div id="mainDiv" class="flex-1 min-h-screen bg-gray-100">
                <!-- Page Content -->
                <main class="py-4 px-4">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
<style scoped>
#mainDiv {
    margin-left: calc(1 / 6 * 100%);
}
@media (max-width: 768px) {
    #mainDiv {
        margin-left: 0;
    }
}
</style>
