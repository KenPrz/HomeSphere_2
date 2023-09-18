<script setup>
import ImageContainer from "@/Components/ImageContainer.vue";
</script>
<template>
    <div class="flex flex-col w-full mx-2">
        <div class="p-3 rounded-t-xl flex items-center bg-zinc-600 w-full">
            <div class="text-white text-lg font-medium ms-5">All Users</div>
        </div>
        <div class="flex flex-col p-3 bg-white h-48 rounded-b-xl shadow-md overflow-auto">
            <div class="flex h-20 items-center w-full p-3" v-for="user in $page.props.userList" :key="user.id">
                <div class="self">
                    <ImageContainer :imageSize="16" :imageVal="user.profile_image" borderRadius="rounded-md"
                        pointerType="cursor-pointer"></ImageContainer>
                </div>
                <div class="ms-4 flex flex-col justify-center">
                    <h1 class="text-md font-semibold">
                        {{
                            user.firstName.charAt(0).toUpperCase() +
                            user.firstName.slice(1).toLowerCase() +
                            ' ' +
                            user.lastName.charAt(0).toUpperCase() +
                            user.lastName.slice(1).toLowerCase()
                        }}
                    </h1>
                    <h2 class="text-md font-light">
                        <span class="text-green-600" v-if="user.is_online === 1">• online</span>
                        <span class="text-slate-500" v-else-if="user.is_online === 0">• offline</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    components: {
        ImageContainer,
    },
    props: {
        filters: Object,
        users: Object,
    },
    data() {
        return {

        };
    },
};
</script>