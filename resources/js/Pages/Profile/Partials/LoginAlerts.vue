<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>
<template>
        <div class="container flex flex-col">
        <div class="my-4 text-xl font-semibold">
            Login Alerts
        </div>
        <div class="flex flex-col border border-slate-400 rounded-md p-3 my-3 hover:bg-slate-400 hover:text-white transition-colors transition-duration: 200ms cursor-default">
            <div class="flex items-center justify-between">
                <div class="flex flex-col">
                    <div class="text-md font-semibold">
                        Email
                    </div>
                    <div class="text-sm font-light">
                        {{ $page.props.auth.user.email }}
                    </div>
                </div>
                <div class="flex items-center">
                    <input type="radio" class="mr-5 cursor-pointer">
                </div>
            </div>
        </div>
        <PrimaryButton>
            Enable
        </PrimaryButton>
    </div>
</template>