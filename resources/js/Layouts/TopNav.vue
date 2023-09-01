<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import ImageContainer from "@/Components/ImageContainer.vue";
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
                            class="text-xl font-bold md:text-center text-center flex items-center hover:text-blue-500 transition-colors"
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
                                        <div v-if="$page.props.auth.user.profile_image != null">
                                            <DropdownLink :href="route('profile.edit')">
                                                Profile
                                            </DropdownLink>
                                        </div>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="transition duration-500 hover:text-red-500"
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
</template>