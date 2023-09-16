<template>
    <DashboardBase title="User Dashboard">
        <div class="bg-gray-100 shadow mx-auto lg:max-w-4xl p-5">
            <label for="select" class="ml-2 text-lg font-semibold">User Chats:</label>
            <inertia-link class="bg-blue-500 text-white py-2 px-4 rounded-md" style="margin-left: 620px;" :href="route('chats.showCreate')">Create Chat</inertia-link>
            <table class="w-full mt-2">
                <thead>
                <tr class="border-collapse border border-gray-300">
                    <th class="py-2 px-4 bg-gray-100 text-center">Chat ID</th>
                    <th class="py-2 px-4 bg-gray-100 text-center">Description</th>
                    <th class="py-2 px-4 bg-gray-100 text-center"></th>
                </tr>
                </thead>
                <tbody>
                <!-- Use v-for to loop through chats and populate table rows -->
                <tr v-for="chat in chats" :key="chat.id">
                    <td class="py-2 px-4 text-center">{{ chat.id }}</td>
                    <td class="py-2 px-4 text-center">{{ chat.description }}</td>
                    <td class="py-2 px-4 text-center" style="text-align: right;">
<!--                        <SecondaryButton @click="handleButtonClick(chat.id)">Open</SecondaryButton>-->
                        <inertia-link class="bg-white text-black py-1 px-2 rounded-md" :href="route('message.index', { id: chat.id })">Open</inertia-link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </DashboardBase>
</template>

<script>
import DashboardBase from './DashboardBase.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from '../Components/SecondaryButton.vue';
import { useRouter } from 'vue-router';
import { InertiaLink } from '@inertiajs/inertia-vue3';

export default {
    components: {
        DashboardBase,
        PrimaryButton,
        SecondaryButton,
        InertiaLink,
    },
    data() {
        return {
            chats: [],
        };
    },
    mounted() {
        // Make an API request to fetch chat data
        axios.get('/chats') // Adjust the URL to match your route
            .then((response) => {
                this.chats = response.data; // Populate the chats array
            })
            .catch((error) => {
                console.error('Error fetching chats:', error);
            });
    },
    setup() {
        const router = useRouter();

        const click = () => {
            router.push('/chats/create');
        };

        return {
            click,
        };
    },
};
</script>
