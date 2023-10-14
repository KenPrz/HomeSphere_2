<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ImageContainer from "@/Components/ImageContainer.vue";
import NavbarProfile from "@/Layouts/partials/NavbarProfile.vue";
</script>

<template>
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
                            class="text-md font-semibold md:text-center text-center flex items-center hover:text-blue-500 transition-colors"
                        >
                            <img
                                class="h-10 w-10 rounded-full p-1 mr-2 hover:scale-110 transition-transform"
                                :src="'/img-assets/favicons/android-chrome-512x512.png'"
                            />
                            <h1 class="ml-3">HomeSphere</h1>
                        </a>
                    </div>
                        <div v-if="$page.props.auth.user" class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative flex items-center">
                                <Dropdown>
                                    <template #trigger>
                                        <img
                                            class="h-9 p-2 rounded-full w-auto bg-slate-500 mr-2 transition duration-200 hover:scale-95 cursor-pointer"
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
                                    <div class="w-"></div>
                                    <template #trigger>
                                        <v-img v-if="$page.props.auth.user.profile_image"
                                                class="rounded-full mx-auto transition duration-200 hover:scale-95 cursor-pointer"
                                                width="38"
                                                :aspect-ratio="1"
                                                :src="'storage/' + $page.props.auth.user.profile_image"
                                                cover
                                            ></v-img>
                                            <v-img v-else
                                                class="rounded-full mx-auto transition duration-200 hover:scale-95 cursor-pointer"
                                                width="38"
                                                :aspect-ratio="1"
                                                src="/img-assets/default_avatar.png"
                                                cover
                                            ></v-img>
                                    </template>
                                    <template #content>
                                        <div>
                                            <DropdownLink :href="route('profile.edit')">
                                                <NavbarProfile/>
                                            </DropdownLink>
                                        </div>
                                        <DropdownLink v-if="$page.props.auth.user.has_home === 1"
                                            :href="route('settings.index')"
                                            method="get"
                                            as="button"
                                            class="transition duration-500"
                                        >
                                        <div class="flex items-center">
                                            <img class="h-6 w-auto me-2" :src="'img-assets/nav-vectors/settings_navbar.svg'" alt="">
                                            <h1>Settings</h1>
                                        </div>
                                            
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="transition duration-500 hover:text-red-500"
                                        >
                                        <div class="flex items-center">
                                            <img class="h-6 w-auto me-2" :src="'img-assets/nav-vectors/logout_navbar.svg'" alt="">
                                            <h1>Logout</h1>
                                        </div>
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                    </div>
                </div>
            </div>
        </nav>
</template>