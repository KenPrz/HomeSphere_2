<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block w-full sm:px-6 lg:px-8">
                <!-- Add a container with a fixed height and overflow-y-auto -->
                <div
                    class="min-w-full justify-between flex mx-0 mb-2 text-base text-left text-white rounded-tl-lg rounded-tr-lg bg-zinc-600"
                >
                    <div
                        v-for="(header, index) in tableHeaders"
                        :key="index"
                        class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5"
                    >
                        {{ header.text }}
                    </div>
                </div>
                <div class="overflow-y-auto" :class="maxHeight">
                    <div class="mx-0">
                        <div
                            v-for="(row, rowIndex) in tableData"
                            :key="rowIndex"
                            class="min-w-full flex  justify-between mb-2 rounded-md text-sm text-left text-black bg-white hover:bg-gray-300 cursor-pointer"
                        >
                            <div
                                v-for="(cell, cellIndex) in row"
                                :key="cellIndex"
                                class="w-1/5 py-4 pl-4 sm:w-1/5 md:w-1/5 lg:w-1/5 xl:w-1/5"
                            >
                                {{ cell }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        tableHeaders: Array,
        tableData: Object,
        maxHeight: String,
    },
};
</script>
