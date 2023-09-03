<script setup>
import ImageContainer from "@/Components/ImageContainer.vue";
</script>
<template>
    <div class="container">
        <div class="flex flex-col rounded-md hover:shadow-lg p-3">
            <div class="flex items-center p-2 border-b-2 border-black">
                <div>
                    <ImageContainer
                        :imageSize="6"
                        :imageVal="$page.props.auth.user.profile_image"
                        borderRadius="rounded-full"
                        pointerType="cursor-pointer"
                        border="border-2 border-gray-800"
                    >
                    </ImageContainer>
                </div>
                <div>
                    <h1 class="ml-2">
                        {{
                            $page.props.auth.user.firstName +
                            " " +
                            $page.props.auth.user.lastName
                        }}
                    </h1>
                </div>
            </div>
            <div
                class="py-1 mt-1 rounded-md text-md font-bold hover:bg-slate-400 hover:text-white transition-colors duration-200"
            >
                <h1 class="ms-2">View Profile</h1>
            </div>
        </div>
    </div>
</template>
