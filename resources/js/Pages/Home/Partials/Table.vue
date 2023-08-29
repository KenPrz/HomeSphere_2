<template>
    <div class="flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block w-full sm:px-6 lg:px-8">
                <div class="table-wrp block max-h-96">
                    <table class="w-full">
                        <thead class="bg-white border-b sticky top-0">
                            <tr class="bg-gray-600">
                                <th
                                    v-for="(header, index) in tableHeaders"
                                    :key="index"
                                    :class="header.class"
                                >
                                    {{ header.text }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="h-96 overflow-y-auto">
                            <tr v-for="(row, index) in tableData" :key="index">
                                <td
                                    v-for="(item, colIndex) in row"
                                    :key="colIndex"
                                >
                                    {{ item }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tableHeaders: [
                {
                    text: "Room",
                    class: "text-md font-medium text-white px-6 py-4 text-left",
                },
                {
                    text: "Type",
                    class: "text-md font-medium text-white px-6 py-4 text-left",
                },
                {
                    text: "Appliances",
                    class: "text-md font-medium text-white px-6 py-4 text-left",
                },
                {
                    text: "Name",
                    class: "text-md font-medium text-white px-6 py-4 text-left",
                },
                {
                    text: "Status",
                    class: "text-md font-medium text-white px-6 py-4 text-left",
                },
            ],
            tableData: [
                // Your dynamic data for each row goes here
                // Example: ["Room 101", "Living Room", "TV, Sofa", "John Doe", "Active"],
                //          ["Room 102", "Bedroom", "Bed, Dresser", "Jane Smith", "Inactive"],
            ],
        };
    },
};
</script>

<style scoped>
/* Your CSS styles go here */
</style>
