<template>
<main>
            <div class="flex">
                <div class="child-main w-8/12">
                    <div class="flex flex-col">
                        <div class="flex flex-col">
                            <div class="mx-3">
                                <div class="Title">
                                    <h1 class="text-3xl mb-2 font-bold tracking-wide">
                                        Welcome to {{ $page.props.homeData.home_name }}
                                    </h1>
                                </div>
                                <div class="mx-3">
                                    <h1 class="text-md font-medium">List of Modes</h1>
                                    <div class="flex flex-wrap">
                                        <ModeCard />
                                        <ModeCard />
                                        <ModeCard />
                                        <ModeCard />
                                    </div>
                                </div>
                            </div>
                            <div class="mx-3">
                                <h1 class="text-md font-medium">List of Appliances</h1>
                                <Table
                                    :tableHeaders="tableHeaders"
                                    :tableData="tableData"
                                    :maxHeight="maxHeight"
                                />
                                <div class="bg-white rounded-md w-full flex justify-end shadow-sm">
                                    <NavLink :href="route('appliances.index')">
                                        <button
                                            class="bg-zinc-600 hover:bg-zinc-700 text-white font-semibold py-2 my-1 mx-1 px-6 border border-gray-300 rounded-xl"
                                        >
                                            View List of Appliances
                                        </button>
                                    </NavLink>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="child-main w-2/6">
                    <div class="flex flex-col h-full">
                        <div class="flex-1">
                            <div class="w-64">
                            <SwiperCard />
                        </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex mx-5">
                            <div class="item">
                                <ImageContainer
                                    :imageSize="16"
                                    :imageVal="
                                        $page.props.auth.user
                                            .profile_image
                                    "
                                    borderRadius="rounded-md"
                                    pointerType="cursor-pointer"
                                >
                                </ImageContainer>
                            </div>
                            <div class="ms-6 flex flex-col justify-center">
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
                                    <span
                                        class="text-green-600"
                                        v-if="
                                            $page.props.auth.user
                                                .is_online === 1
                                        "
                                        >• online</span
                                    >
                                    <span
                                        class="text-slate-500"
                                        v-else="
                                            $page.props.auth.user
                                                .is_online === 0
                                        "
                                        >• offline</span
                                    >
                                </h2>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

</template>