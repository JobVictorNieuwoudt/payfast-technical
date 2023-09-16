<template>
    <DashboardBase title="Create New Chat">
        <div class="bg-gray-100 shadow mx-auto lg:max-w-4xl">
            <div class="p-5">
                <form @submit.prevent="createChat">
                    <div class="mb-4">
                        <label for="chatDescription" class="block text-lg font-semibold">
                            Chat Description:
                        </label>
                        <input
                            v-model="chatDescription"
                            type="text"
                            id="chatDescription"
                            name="chatDescription"
                            class="mt-2 p-2 border rounded-md w-full"
                            placeholder="Enter chat description"
                            required
                        />
                    </div>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md">
                        Create
                    </button>
                </form>
            </div>
        </div>
    </DashboardBase>
</template>

<script>
import DashboardBase from './DashboardBase.vue';
import axios from 'axios';

export default {
    components: {
        DashboardBase,
    },
    data() {
        return {
            chatDescription: '', // Store the chat description input
        };
    },
    methods: {
        createChat() {
            axios
                .post('/chats', { description: this.chatDescription })
                .then((response) => {
                    // Handle success, e.g., redirect to a success page
                    console.log('Chat created successfully', response.data);
                    // Redirect to a success page or perform other actions
                    this.$inertia.visit('/dashboard');
                })
                .catch((error) => {
                    // Handle error, e.g., show an error message
                    console.error('Error creating chat', error);
                });
        },
    },
};
</script>
