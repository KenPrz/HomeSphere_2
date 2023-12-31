<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import SideNavLink from "@/Components/SideNavLink.vue";
import Modal from "@/Components/Modal.vue";
</script>
<template>
    <div class="fixed bottom-0 w-full md:w-1/6 bg-white shadow-md md:h-screen lg:pt-16 z-40">
        <div class="text-center md:block hidden items-center mt-8">
            <v-img v-if="$page.props.auth.user.profile_image" class="rounded-md mx-auto" width="150" :aspect-ratio="1"
                :src="'storage/' + $page.props.auth.user.profile_image" cover></v-img>
            <v-img v-else class="rounded-md mx-auto" width="150" :aspect-ratio="1" src="/img-assets/default_avatar.png"
                cover></v-img>
            <div class="image-text mt-4">
                <h5 class="mb-1">Welcome Back!</h5>
                <h2 class="font-bold text-md">
                    {{
                        $page.props.auth.user.firstName
                            .charAt(0)
                            .toUpperCase() +
                        $page.props.auth.user.firstName.slice(1).toLowerCase() +
                        " " +
                        $page.props.auth.user.lastName.charAt(0).toUpperCase() +
                        $page.props.auth.user.lastName.slice(1).toLowerCase()
                    }}
                </h2>
            </div>
        </div>
        <div class="sm:mt-0 lg:mt-4">
            <ul class="flex flex-row md:flex-col items-start mx-3 h-full">
                <SideNavLink :href="route('dashboard')" :active="route().current('verify') || route().current('dashboard')">
                    <li
                        class="flex p-1 py-2 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out">
                        <img :src="'/img-assets/nav-vectors/home.svg'" alt="Home" class="w-5 h-auto lg:mr-3 lg:ml-5" />
                        <div class="hidden sm:block lg:text-md mt-1">Home</div>
                    </li>
                </SideNavLink>
                <SideNavLink :href="route('profile.edit')" :active="route().current('profile.edit')">
                    <li
                        class="flex p-1 py-2 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out">
                        <img :src="'/img-assets/nav-vectors/account.svg'" alt="Profile"
                            class="w-5 h-auto lg:mr-3 lg:ml-5" />
                        <div class="hidden sm:block lg:text-md mt-1">
                            Profile
                        </div>
                    </li>
                </SideNavLink>

                <SideNavLink v-if="$page.props.auth.user.has_home === 1" :href="route('appliances.index')"
                    :active="route().current('appliances.index')">
                    <li
                        class="flex p-1 py-2 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out">
                        <img :src="'/img-assets/nav-vectors/appliances.svg'" alt="Appliances"
                            class="w-5 h-auto lg:mr-3 lg:ml-5" />
                        <div class="hidden sm:block lg:text-md mt-1">
                            Appliances
                        </div>
                    </li>
                </SideNavLink>
                <SideNavLink v-if="$page.props.auth.user.has_home === 1" :href="route('rooms.index')"
                    :active="route().current('rooms.index')">
                    <li
                        class="flex p-1 py-2 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out">
                        <img :src="'/img-assets/nav-vectors/rooms.svg'" alt="Rooms" class="w-5 h-auto lg:mr-3 lg:ml-5" />
                        <div class="hidden sm:block lg:text-md mt-1">Rooms</div>
                    </li>
                </SideNavLink>
                <SideNavLink v-if="$page.props.auth.user.has_home === 1 && 
                    ($page.props.homeData.role== 'owner' || $page.props.homeData.role== 'admin')" :href="route('modes.index')"
                    :active="route().current('modes.index')">
                    <li
                        class="flex p-1 py-2 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out">
                        <img :src="'/img-assets/nav-vectors/modes.svg'" alt="Modes" class="w-5 h-auto lg:mr-3 lg:ml-5" />
                        <div class="hidden sm:block lg:text-md mt-1">Modes</div>
                    </li>
                </SideNavLink>
                <SideNavLink v-if="$page.props.auth.user.has_home === 1" :href="route('settings.index')"
                    :active="route().current('settings.index')">
                    <li
                        class="flex p-1 py-2 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out">
                        <img :src="'/img-assets/nav-vectors/settings.svg'" alt="Settings"
                            class="w-5 h-auto lg:mr-3 lg:ml-5" />
                        <div class="hidden sm:block lg:text-md mt-1">
                            Settings
                        </div>
                    </li>
                </SideNavLink>
                <div class="hidden md:block lg:text-md w-auto mt-5">
                    <a @click="openLogoutModal"  href="#" class="bottom">
                        <li class="flex mb-4 ms-4">
                            <img :src="'/img-assets/nav-vectors/logout.svg'" alt="Settings" class="w-5 h-auto lg:mr-3 lg:ml-2" />
                            <div class="hidden sm:block lg:text-md mt-1 hover:text-red-600 transition-colors duration-250">
                                Logout
                            </div>
                        </li>
                    </a>
                </div>
            </ul>
        </div>
    </div>
    <Modal :maxWidth="'sm'" :show="showLogoutModal" @close="closeLogoutModal">
            <div class="bg-white p-6 rounded-lg shadow-md w-auto">
        <h2 class="text-xl font-semibold mb-4">Logout?</h2>
        <p class="mb-4">Are you sure you want to logout?</p>
        <div class="flex">
            <button
                @click="closeLogoutModal"
                class="flex-1 text-sm bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-4 hover:bg-gray-400 transition duration-300"
            >
                No, cancel
            </button>
            <Link :href="route('logout')"
                method="post" as="button"
                class="flex-1 text-sm bg-red-500 text-white mr-6 px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300"
            >
                Yes, logout
            </Link>
        </div>
    </div>
    </Modal>
</template>
<script>
    const showLogoutModal = ref(false);
    const openLogoutModal = () => {
        showLogoutModal.value = true;
    };
    const closeLogoutModal = () => {
        showLogoutModal.value = false;
    };
    export default {
        props: {
            homeData: {
                type: Object,
                default: null
            }
        }
    }
</script>
