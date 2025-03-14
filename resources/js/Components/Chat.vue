<template>
    <div class="chat-container">
        <div class="messages">
            <div v-for="message in messages" :key="message.id" class="message">
                <strong>{{ message.user.name }}:</strong> {{ message.message }}
            </div>
        </div>
        <textarea v-model="newMessage" @keyup.enter="sendMessage" placeholder="Écrire un message" />
        <button class="mt-2" @click="sendMessage">Envoyer</button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    listId: {
        type: Number,
        required: true
    }
});

const messages = ref([]);
const newMessage = ref('');

const fetchMessages = async () => {
    try {
        const response = await axios.get(`/lists/${props.listId}/chat/messages`);
        messages.value = response.data;
    } catch (error) {
        console.error('Erreur lors de la récupération des messages:', error);
    }
};

const sendMessage = async () => {
    if (!newMessage.value.trim()) return;

    try {
        await axios.post(`/lists/${props.listId}/chat`, {
            message: newMessage.value,
            listId: props.listId
        });
        newMessage.value = '';
        fetchMessages();
    } catch (error) {
        console.error('Erreur lors de l\'envoi du message:', error);
    }
};

onMounted(() => {
    fetchMessages();
});
</script>

<style scoped>
.chat-container {
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 5px;
    max-width: 600px;
    margin: 0 auto;
}

.messages {
    flex: 1;
    max-height: 300px;
    overflow-y: auto;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
    padding: 10px;
}

.message {
    padding: 5px 0;
}

textarea {
    resize: none;
    height: 60px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
}

button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>