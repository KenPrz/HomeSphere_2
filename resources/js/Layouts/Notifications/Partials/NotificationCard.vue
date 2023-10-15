<script setup>
</script>
<template>
    <div class="container text-md">
        <a class="container my-1 py-1 rounded-md flex justify-around items-center cursor-pointer hover:bg-slate-200">
            <div class="flex item-center ms-2 me-1">
                <v-img v-if="$page.props.auth.user.profile_image"
                    class="rounded-full mx-auto"
                    width="60"
                    :aspect-ratio="1"
                    :src="'storage/' + $page.props.auth.user.profile_image"
                    cover
                ></v-img>
                <v-img v-else
                    class="rounded-full mx-auto"
                    width="60"
                    :aspect-ratio="1"
                    src="/img-assets/default_avatar.png"
                    cover
                ></v-img>
            </div>
            <div class="mx-1 flex items-center">
                <div class="text-sm  text-slate-600">
                    <span class="font-semibold">
                    {{ $page.props.auth.user.firstName + " " + $page.props.auth.user.lastName }}
                    </span>
                    message here
                </div>
            </div>
        </a>
    </div>
</template>