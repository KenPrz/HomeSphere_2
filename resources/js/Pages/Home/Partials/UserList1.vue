<script setup>
    import ImageContainer from "@/Components/ImageContainer.vue";
</script>
<template>
    <div class="flex flex-col w-full mx-2">
        <div class="p-3 rounded-t-xl flex items-center bg-zinc-600  w-full">
            <div class=" text-white text-lg font-medium ms-5">
                All Users
            </div>
        </div>
        <div class="flex flex-col p-3 bg-white h-48 rounded-b-xl shadow-md overflow-auto">
            <div class="flex h-20 items-center w-full p-3">
                <div class="self">
                    <ImageContainer :imageSize="16" :imageVal="$page.props.auth.user
                            .profile_image
                        " borderRadius="rounded-md" pointerType="cursor-pointer">
                    </ImageContainer>
                </div>
                <div class="ms-4 flex flex-col justify-center">
                    <h1 class="text-md font-semibold">
                        {{
                            $page.props.auth.user.firstName
                                .charAt(0)
                                .toUpperCase() +
                            $page.props.auth.user.firstName
                                .slice(1)
                                .toLowerCase() +
                            " " +
                            $page.props.auth.user.lastName
                                .charAt(0)
                                .toUpperCase() +
                            $page.props.auth.user.lastName
                                .slice(1)
                                .toLowerCase()
                        }}
                    </h1>
                    <h2 class="text-md font-light">
                        <span class="text-green-600" v-if="$page.props.auth.user
                                    .is_online === 1
                                ">• online</span>
                        <span class="text-slate-500"
                            v-else="$page.props.auth.user.is_online === 0">
                            • offline
                        </span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</template>