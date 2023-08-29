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
                        <div class="ml-3 relative flex items-center">
                            <Dropdown>
                                <template #trigger>
                                    <img
                                        class="h-9 p-2 rounded-full w-auto bg-gray-800 mr-2 transition duration-200 hover:scale-95 cursor-pointer"
                                        :src="'/img-assets/nav-vectors/notification.svg'"
                                        alt=""
                                    />
                                </template>
                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Notification1
                                    </DropdownLink>
                                    <DropdownLink :href="route('profile.edit')">
                                        Notification3
                                    </DropdownLink>
                                    <DropdownLink :href="route('profile.edit')">
                                        Notification3
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <ImageContainer
                                        :imageSize="9"
                                        :imageVal="
                                            $page.props.auth.user.profile_image
                                        "
                                        borderRadius="rounded-full"
                                        pointerType="cursor-pointer"
                                        border="border-2 border-gray-800"
                                    >
                                    </ImageContainer>
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
                <div class="text-center pt-10 md:block hidden items-center">
                    <ImageContainer
                        :imageSize="48"
                        :imageVal="$page.props.auth.user.profile_image"
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
                                class="flex p-1 py-4 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out"
                            >
                                <img
                                    :src="'/img-assets/nav-vectors/home.svg'"
                                    alt="Home"
                                    class="w-7 h-auto lg:mr-3 lg:ml-5"
                                />
                                <div class="hidden sm:block lg:text-xl mt-1">
                                    Home
                                </div>
                            </li>
                        </SideNavLink>
                        <SideNavLink
                            :href="route('profile.edit')"
                            :active="route().current('profile.edit')"
                        >
                            <li
                                class="flex p-1 py-4 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out"
                            >
                                <img
                                    :src="'/img-assets/nav-vectors/account.svg'"
                                    alt="Profile"
                                    class="w-7 h-auto lg:mr-3 lg:ml-5"
                                />
                                <div class="hidden sm:block lg:text-xl mt-1">
                                    Profile
                                </div>
                            </li>
                        </SideNavLink>
                        <a href="#" class="w-full">
                            <li
                                class="flex p-1 py-4 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out"
                            >
                                <img
                                    :src="'/img-assets/nav-vectors/appliances.svg'"
                                    alt="Appliances"
                                    class="w-7 h-auto lg:mr-3 lg:ml-5"
                                />
                                <div class="hidden sm:block lg:text-xl mt-1">
                                    Appliances
                                </div>
                            </li>
                        </a>
                        <a href="#" class="w-full">
                            <li
                                class="flex p-1 py-4 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out"
                            >
                                <img
                                    :src="'/img-assets/nav-vectors/rooms.svg'"
                                    alt="Rooms"
                                    class="w-7 h-auto lg:mr-3 lg:ml-5"
                                />
                                <div class="hidden sm:block lg:text-xl mt-1">
                                    Rooms
                                </div>
                            </li>
                        </a>
                        <a href="#" class="w-full">
                            <li
                                class="flex p-1 py-4 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out"
                            >
                                <img
                                    :src="'/img-assets/nav-vectors/modes.svg'"
                                    alt="Modes"
                                    class="w-7 h-auto lg:mr-3 lg:ml-5"
                                />
                                <div class="hidden sm:block lg:text-xl mt-1">
                                    Modes
                                </div>
                            </li>
                        </a>
                        <a href="#" class="w-full">
                            <li
                                class="flex p-1 py-4 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out"
                            >
                                <img
                                    :src="'/img-assets/nav-vectors/settings.svg'"
                                    alt="Settings"
                                    class="w-7 h-auto lg:mr-3 lg:ml-5"
                                />
                                <div class="hidden sm:block lg:text-xl mt-1">
                                    Settings
                                </div>
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
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
