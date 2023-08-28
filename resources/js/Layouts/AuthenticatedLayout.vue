<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import ImageContainer from "@/Components/ImageContainer.vue";
import SideNavLink from "@/Components/SideNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>
<template>
    <div class="grid grid-cols-1 min-h-screen">
        <!-- Navbar -->
        <nav
            class="px-10 bg-white border-b shadow-sm border-gray-100 sticky top-0 z-50"
        >
            <!-- Primary Navigation Menu -->
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <a
                            :href="route('dashboard')"
                            class="text-xl font-bold md:text-center text-center flex items-center hover:text-blue-500 transition-colors"
                        >
                            <img
                                class="h-10 w-10 rounded-full p-1 mr-2 hover:scale-110 transition-transform"
                                :src="'/img-assets/favicons/android-chrome-512x512.png'"
                            />
                            <h1 class="ml-3">HomeSphere</h1>
                        </a>
                    </div>
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                        >
                                            {{
                                                $page.props.auth.user.firstName
                                            }}
                                            <svg
                                                class="ml-2 -mr-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                    >
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="md:flex">
            <!-- Sidebar -->
            <div
                class="fixed bottom-0 w-full md:w-1/6 bg-white shadow-md md:h-screen lg:pt-16"
            >
                <div class="lg:my-10  text-center pt-10 md:block hidden items-center">
                    <ImageContainer 
                        :imageSize="48"
                        :imageVal= $page.props.auth.user.profile_image
                    />
                    <div class="image-text mt-4">
                        <h5 class="mb-1">Welcome Back!!</h5>
                        <h2 class="font-extrabold text-xl">
                            {{
                                $page.props.auth.user.firstName +
                                " " +
                                $page.props.auth.user.lastName
                            }}
                        </h2>
                    </div>
                </div>
                <div class="sm:mt-0 lg:mt-6">
                    <ul class="flex flex-row md:flex-col items-start mx-3">
                        <SideNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            <li
                                class="flex p-2 py-4 hover:bg-slate-400  rounded-lg w-full item-center transition-colors duration-500 ease-in-out"
                            >
                                <img
                                    :src="'/img-assets/nav-vectors/home.svg'"
                                    alt="Home"
                                    class="w-9 h-auto lg:mr-4 lg:ml-7"
                                />
                                <div class="hidden sm:block lg:text-xl mt-1">Home</div>
                            </li>
                        </SideNavLink>
                        <SideNavLink
                            :href="route('profile.edit')"
                            :active="route().current('profile.edit')"
                        >
                            <li
                                class="flex p-2 py-4 hover:bg-slate-400  rounded-lg w-full item-center transition-colors duration-500 ease-in-out"
                            >
                                <img
                                    :src="'/img-assets/nav-vectors/account.svg'"
                                    alt="Home"
                                    class="w-9 h-auto lg:mr-4 lg:ml-7"
                                />
                                <div class="hidden sm:block lg:text-xl mt-1">Profile</div>
                            </li>
                        </SideNavLink>
                    </ul>
                </div>
            </div>
            <!-- End Sidebar -->
            <!-- Main Content -->
            <div id="mainDiv" class="flex-1 min-h-screen bg-gray-100">
                <!-- Page Content -->
                <main class="py-8 px-4">
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