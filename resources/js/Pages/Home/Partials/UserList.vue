<template>
    <div class="flex flex-col w-full mx-2">
        <div class="p-3 rounded-t-xl flex items-center bg-zinc-600 w-full">
            <div class="text-white text-lg font-medium ms-5">All Users</div>
        </div>
        <div class="flex flex-col p-3 bg-white h-48 rounded-b-xl shadow-md overflow-auto">
            <div class="flex h-20 items-center w-full p-3" v-for="user in $page.props.userList" :key="user.id">
                <div class="self">
                        <v-img v-if="user.profile_image"
                            class="rounded-md mx-auto"
                            width="60"
                            :aspect-ratio="1"
                            :src="'storage/' + user.profile_image"
                            cover
                        ></v-img>
                        <v-img v-else
                            class="rounded-md mx-auto"
                            width="60"
                            :aspect-ratio="1"
                            src="/img-assets/default_avatar.png"
                            cover
                        ></v-img>
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
    props: {
        filters: Object,
        users: Object,
    }
};
</script>