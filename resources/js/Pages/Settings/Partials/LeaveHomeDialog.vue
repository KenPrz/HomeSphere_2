<script setup>
    
</script>
<template>
    <div>
        <div class="container">
            <div class="flex flex-col">
                <div class="header text-center text-xl font semibold">
                    Leave home?
                </div>
                <div class="flex justify-around">
                    <button @click="leaveHome($page.props.auth.user.id)"
                        class="bg-zinc-600 hover:bg-zinc-700 m-2 px-8 rounded text-white">
                        Yes
                    </button>
                    <button @click="close()">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>