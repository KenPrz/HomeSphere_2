<script setup>
import ImageContainer from "@/Components/ImageContainer.vue";
import SideNavLink from "@/Components/SideNavLink.vue";
</script>
<template>
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
                        <div class="hidden sm:block lg:text-xl mt-1">Home</div>
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
                
                <SideNavLink
                    :href="route('appliances.index')"
                    :active="route().current('appliances.index')"
                >
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
                </SideNavLink>
                <a href="#" class="w-full">
                    <li
                        class="flex p-1 py-4 hover:bg-slate-400 rounded-md w-full lg:items-center lg:justify-start items-center justify-center transition-colors duration-500 ease-in-out"
                    >
                        <img
                            :src="'/img-assets/nav-vectors/rooms.svg'"
                            alt="Rooms"
                            class="w-7 h-auto lg:mr-3 lg:ml-5"
                        />
                        <div class="hidden sm:block lg:text-xl mt-1">Rooms</div>
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
                        <div class="hidden sm:block lg:text-xl mt-1">Modes</div>
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
</template>
