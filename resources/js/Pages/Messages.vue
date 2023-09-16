<template>
    <DashboardBase title="Messages">
        <div class="bg-gray-100 shadow mx-auto lg:max-w-4xl">
            <div class="p-5">
                <div>
                    <h1>{{ pageTitle }}</h1>
                    <table class="w-full mt-2">
                        <thead>
                        <tr class="border-collapse border border-gray-300">
                            <th class="py-2 px-4 bg-gray-100 text-left">Message ID</th>
                            <th class="py-2 px-4 bg-gray-100 text-left">User</th>
                            <th class="py-2 px-4 bg-gray-100 text-left">Message</th>
                            <th class="py-2 px-4 bg-gray-100 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(message, index) in $page.props.messages" :key="message.id">
                            <td class="py-2 px-4 text-left">{{ message.id }}</td>
                            <td class="py-2 px-4 text-left">{{ message.name }}</td>
                            <td class="py-2 px-4 text-left">
                                <template v-if="!message.isEditing">
                                    {{ message.message }}
                                </template>
                                <template v-else>
                                    <input v-model="editedMessages[index]" class="w-full" />
                                </template>
                            </td>
                            <td class="py-2 px-4 text-left" v-if="isAdmin === 0">
                                <div class="flex">
                                    <button v-if="message.user_id === userId && !message.isEditing" @click="startEditing(message)">
                                        <SecondaryButton>Update</SecondaryButton>
                                    </button>
                                    <button v-if="message.user_id === userId && message.isEditing" @click="saveEditedMessage(message, index)">
                                        <SecondaryButton>Save</SecondaryButton>
                                    </button>
                                    <button v-if="message.user_id === userId && !message.isEditing" @click="deleteMessage(message)">
                                        <SecondaryButton>Delete</SecondaryButton>
                                    </button>
                                </div>
                            </td>
                            <td class="py-2 px-4 text-left" v-if="isAdmin === 1">
                                <div class="flex">
                                    <button v-if="!message.isEditing" @click="startEditing(message)">
                                        <SecondaryButton>Update</SecondaryButton>
                                    </button>
                                    <button v-if="message.isEditing" @click="saveEditedMessage(message, index)">
                                        <SecondaryButton>Save</SecondaryButton>
                                    </button>
                                    <button v-if="!message.isEditing" @click="deleteMessage(message)">
                                        <SecondaryButton>Delete</SecondaryButton>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <template v-if="!isEditing">
                                    <form @submit.prevent="createMessage">
                                        <textarea v-model="newMessage" class="w-full" rows="5" placeholder="Enter your message here" required></textarea>
                                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create</button>
                                    </form>
                                </template>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </DashboardBase>
</template>

<script>
import DashboardBase from './DashboardBase.vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import axios from "axios";
import { useRoute } from "vue-router";

export default {
    components: {
        SecondaryButton,
        DashboardBase,
    },
    data() {
        return {
            userId: null,
            isAdmin: null,
            newMessage: '',
            editedMessages: [], // Track edited messages
        };
    },
    created() {
        this.userId = this.$page.props.auth.user.id;
        this.isAdmin = this.$page.props.auth.user.is_admin;
        // Initialize editedMessages array with empty strings
        this.editedMessages = Array(this.$page.props.messages.length).fill('');
    },
    methods: {
        createMessage() {
            // Create and send the new message
            const chatId = this.$route.params.id;
            axios
                .post(`/chats/${chatId}/messages`, { message: this.newMessage })
                .then((response) => {
                    console.log('Message created successfully', response.data);
                    this.$page.props.messages.push(response.data);
                    // clear the textarea
                    this.newMessage = '';
                })
                .catch((error) => {
                    // Handle error, e.g., show an error message
                    console.error('Error creating message', error);
                });
        },
        startEditing(message) {
            // Set the message's editing flag to true
            message.isEditing = true;
        },
        saveEditedMessage(message, index) {
            // Save the edited message to the server
            const updatedMessage = this.editedMessages[index];
            const chatId = this.$route.params.id;

            axios
                .put(`/chats/${chatId}/messages/${message.id}`, { message: updatedMessage })
                .then((response) => {
                    console.log('Message updated successfully', response.data);
                    message.message = updatedMessage;
                    message.isEditing = false;
                })
                .catch((error) => {
                    // Handle error, e.g., show an error message
                    console.error('Error updating message', error);
                });
        },
        deleteMessage(message) {
            const chatId = this.$route.params.id;

            axios
                .delete(`/chats/${chatId}/messages/${message.id}`)
                .then(() => {
                    console.log('Message deleted successfully');
                    // Remove the message from the messages array
                    const index = this.$page.props.messages.findIndex((m) => m.id === message.id);
                    if (index !== -1) {
                        this.$page.props.messages.splice(index, 1);
                    }
                })
                .catch((error) => {
                    // Handle error, e.g., show an error message
                    console.error('Error deleting message', error);
                });
        },
    },
    computed: {
        pageTitle() {
            return this.isAdmin === 0 ? 'User Message Manager' : 'Admin Message Manager';
        },
    },
};
</script>
