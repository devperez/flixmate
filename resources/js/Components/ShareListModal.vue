<template>
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="text-lg font-semibold mb-4">Partager la liste avec :</h4>
            <ul>
                <li v-for="contact in filteredConnections" :key="contact.id" class="flex items-center mb-2">
                    <input type="checkbox" :id="'contact-' + contact.id" :value="contact.id" v-model="selectedContacts" :disabled="isSharedWithContact(contact.id)">
                    <label :for="'contact-' + contact.id" class="ml-2" :class="{'text-gray-400': isSharedWithContact(contact.id)}">
                        {{ contact.name }}
                        <span v-if="isSharedWithContact(contact.id)">(Déjà partagé)</span>
                    </label>
                </li>
            </ul>
            <button @click="confirmShare" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">
                Confirmer
            </button>
            <button @click="closeModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded ml-2">
                Annuler
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    listId: Number,
    activeConnections: Array,
    sharedContacts: Array, // Contacts avec lesquels la liste est déjà partagée
    ownerId: Number,
    currentUserId: Number,
});

const emits = defineEmits(['close', 'shared']);

const showModal = ref(true);
const selectedContacts = ref([]);

const isSharedWithContact = (contactId) => {
    if (!props.sharedContacts) {
        return false;
    }
    
    return props.sharedContacts.includes(contactId);
};

const filteredConnections = computed(() => {
    return props.activeConnections.filter(connection =>
        connection.id !== props.ownerId && connection.id !== props.currentUserId
    );
});

const confirmShare = async () => {
    if (selectedContacts.value.length > 0) {
        try {
            await axios.post(route('share-list'), {
                listId: props.listId,
                contacts: selectedContacts.value,
            });
            emits('shared');
            closeModal();
        } catch (error) {
            console.error('Erreur lors du partage de la liste:', error);
        }
    } else {
        alert('Veuillez sélectionner au moins un contact.');
    }
};

const closeModal = () => {
    showModal.value = false;
    emits('close');
};
</script>

