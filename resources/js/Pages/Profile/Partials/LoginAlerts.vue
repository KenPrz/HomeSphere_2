<script setup>
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import ToggleSwitch from '@/Components/ToggleSwitch.vue';
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
                        {{ auth.user.email }}
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="me-2">{{ loginAlerts ? 'Enabled' : 'Disabled'  }}</span>
                    <ToggleSwitch v-model="loginAlerts" />
                </div>
            </div>
        </div>
        <PrimaryButton @click="submit">
            {{ loginAlerts ? 'Enable' : 'Disable'  }}
        </PrimaryButton>
    </div>
</template>
<script>
    export default {
        props: {
            auth: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                loginAlerts: this.auth.user.has_login_alerts
            }
        },
        methods: {
            submit(){
                this.$inertia.put(route('profile.toggleAlerts'), {
                    user_id: this.auth.user.id,
                    loginAlerts: this.loginAlerts,
                }),{
                    preserveState: true,
                    onSuccess: () => {
                        this.$emit('close');
                    },
                    onError: () => {
                        this.$toast.error('Something went wrong');
                    }
                }
            }
        }
    }
</script>