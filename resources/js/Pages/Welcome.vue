<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div class="centered-content">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg" style="padding: 25px;">
                <template v-if="canLogin">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="prominent-link"
                    >Dashboard</Link
                    >

                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="prominent-link"
                        >Log in</Link
                        >

                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="prominent-link"
                        >Register</Link
                        >
                    </template>
                </template>
            </div>
        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-color: #F3F4F6; /* Set the background color to off-white */
}
/* Center the content vertically and horizontally */
.centered-content {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Make the container cover the entire viewport height */
}

/* Style the links */
.prominent-link {
    font-size: 24px; /* Increase the font size to make it more prominent */
    font-weight: bold;
    text-decoration: none;
    color: #333; /* Change the text color to your preference */
    padding: 10px 20px; /* Add some padding for better visibility */
    border: 2px solid #333; /* Add a border for emphasis */
    border-radius: 5px; /* Round the corners of the links */
    margin: 10px; /* Add some spacing between links */
}

/* Style for hover effect */
.prominent-link:hover {
    background-color: #333; /* Change the background color on hover */
    color: #fff; /* Change the text color on hover */
}
</style>
