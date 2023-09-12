<script setup>
import { ref } from "vue";
import TopNav from "@/Layouts/TopNav.vue";
import SideNav from "@/Layouts/SideNav.vue";

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
