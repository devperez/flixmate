<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Contacts
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-4">
                    <input type="text" v-model="searchQuery" @input="searchEmails" placeholder="Rechercher un email..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-md" />
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <!-- Afficher les résultats ici -->
                    <div v-if="user" class="border p-4">
                        <p><strong>Nom:</strong> {{ user.name }}</p>
                        <p><strong>Email:</strong> {{ user.email }}</p>
                        <button @click="addToContacts" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
                            Ajouter à mes contacts
                        </button>

                    </div>
                    <div v-else>
                        <p>Aucun utilisateur trouvé.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold">Demandes en attente</h3>
                    <div v-if="pendingConnections.length > 0">
                        <div v-for="connection in pendingConnections" :key="connection.id" class="border p-4 mb-2">
                            <p><strong>Nom:</strong> {{ connection.user.name }}</p>
                            <p><strong>Email:</strong> {{ connection.user.email }}</p>
                            <button @click="acceptConnection(connection.id)" class="px-4 py-2 bg-green-500 text-white rounded">
                                Accepter
                            </button>
                            <button @click="rejectConnection(connection.id)" class="px-4 py-2 bg-red-500 text-white rounded ml-2">
                                Rejeter
                            </button>
                        </div>
                    </div>
                    <div v-else>
                        <p>Aucune demande en attente.</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold">Connexions en cours</h3>
                    <div v-if="activeConnections.length > 0">
                        <div v-for="connection in activeConnections" :key="connection.id" class="border p-4 mb-2">
                            <p><strong>Nom:</strong> {{ connection.connected_user_id === user.id ? connection.user.name : connection.connectedUser.name }}</p>
                            <p><strong>Email:</strong> {{ connection.connected_user_id === user.id ? connection.user.email : connection.connectedUser.email }}</p>
                        </div>
                    </div>
                    <div v-else>
                        <p>Aucune connexion en cours.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>



<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { debounce } from 'lodash';

const searchQuery = ref('');
const user = ref(null);
const pendingConnections = ref([]);
const activeConnections = ref([]);

const fetchConnections = async () => {
    try {
        const response = await axios.get(route('contacts.connections'));
        pendingConnections.value = response.data.pendingConnections;
        activeConnections.value = response.data.activeConnections;
        user.value = response.data.user;
    } catch (error) {
        console.error('Erreur lors de la récupération des connexions:', error);
    }
};

const searchEmails = debounce(async () => {
    if (searchQuery.value.length < 3) {
        user.value = null;
        return;
    }

    try {
        const response = await axios.get(route('contacts.search'), {
            params: { query: searchQuery.value }
        });
        user.value = response.data;
    } catch (error) {
        console.error('Erreur lors de la recherche des emails:', error);
    }
}, 300);

const addToContacts = async () => {
    try {
        await axios.post(route('contacts.add', { id: user.value.id }));
        alert('Utilisateur ajouté à vos contacts!');
    } catch (error) {
        console.error('Erreur lors de l\'ajout de l\'utilisateur:', error);
    }
}
onMounted(() => {
    searchEmails();
});
</script>