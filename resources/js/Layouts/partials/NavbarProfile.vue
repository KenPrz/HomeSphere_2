<script setup>
import ImageContainer from "@/Components/ImageContainer.vue";
</script>
<template>
    <div class="container">
        <div class="flex flex-col rounded-md hover:shadow-lg p-3">
            <div class="flex items-center p-2 border-b-2 border-slate-400">
                <div>
                    <v-img v-if="$page.props.auth.user.profile_image"
                        class="rounded-full mx-auto"
                        width="30"
                        :aspect-ratio="1"
                        :src="'storage/' + $page.props.auth.user.profile_image"
                        cover
                    ></v-img>
                    <v-img v-else
                        class="rounded-full mx-auto"
                        width="30"
                        :aspect-ratio="1"
                        src="/img-assets/default_avatar.png"
                        cover
                    ></v-img>
                </div>
                <div>
                    <h1 class="ml-2">
                        {{
                        $page.props.auth.user.firstName
                            .charAt(0)
                            .toUpperCase() +
                        $page.props.auth.user.firstName.slice(1).toLowerCase() +
                        " " +
                        $page.props.auth.user.lastName.charAt(0).toUpperCase() +
                        $page.props.auth.user.lastName.slice(1).toLowerCase()
                    }}
                    </h1>
                </div>
            </div>
            <div
                class="py-1 mt-1 rounded-md text-xs font-light hover:bg-slate-400 hover:text-white transition-colors duration-200"
            >
                <h1 class="ms-2 text-start">View Profile</h1>
            </div>
        </div>
    </div>
</template>
