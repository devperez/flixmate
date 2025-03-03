<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ShareListModal from '@/Components/ShareListModal.vue';

// Récupérer l'ID depuis les props
const props = defineProps(['id']);

// Références réactives
const listName = ref('');
const lists = ref([]);
const tv = ref(null);
const activeConnections = ref([]);
const selectedListId = ref(null);
const showShareModal = ref(false);

// Récupérer les détails de la série TV depuis TMDb
const fetchTvDetails = async () => {
    try {
        const response = await fetch(
            `https://api.themoviedb.org/3/tv/${props.id}`,
            {
                headers: {
                    accept: 'application/json',
                    Authorization: `Bearer ${import.meta.env.VITE_TMDB_TOKEN}`,
                },
            }
        );
        const data = await response.json();
        tv.value = data;
    } catch (error) {
        console.error('Erreur lors de la récupération des détails de la série :', error);
    }
};

// Récupérer les listes de l'utilisateur
const fetchLists = async () => {
    try {
        const response = await axios.get(route('lists.index'));
        lists.value = response.data.lists.map(list => ({
            ...list,
            showContacts: false,
            selectedContacts: []
        }));
    } catch (error) {
        console.error('Erreur lors de la récupération des listes:', error);
    }
};

// Récupérer les connexions actives de l'utilisateur
const fetchConnections = async () => {
    try {
        const response = await axios.get(route('contacts.connections'));
        activeConnections.value = response.data.activeConnections.map(connection => connection.connected_user);
        //console.log('Contacts actifs:', activeConnections.value); // Ajoutez ce log
    } catch (error) {
        console.error('Erreur lors de la récupération des connexions:', error);
    }
};

// Fonction pour créer une liste
const createList = async () => {
    if (listName.value.trim() === '') {
        alert('Veuillez entrer un nom de liste');
        return;
    }

    try {
        const response = await axios.post(route('lists.store'), {
            name: listName.value
        });

        lists.value.push({
            ...response.data,
            showContacts: false,
            selectedContacts: []
        });
        listName.value = ''; // Réinitialiser le champ après création
    } catch (error) {
        console.error('Erreur lors de la création de la liste:', error);
    }
};

// Fonction pour ajouter une série à une liste
const addToList = async (listId) => {
    if (!tv.value) return;
    try {
        await axios.post(route('lists.add_movie', { list: listId }), {
            tv_id: tv.value.id, // On envoie l'id de la série
            name: tv.value.name, // On récupère le nom
            poster: tv.value.poster_path,
            release: tv.value.first_air_date,
        });
        alert(`"${tv.value.name}" ajouté à la liste !`);
    } catch (error) {
        console.error('Erreur lors de l\'ajout à la liste:', error);
    }
};

const openShareModal = (index) => {
    selectedListId.value = lists.value[index].id;
    showShareModal.value = true;
};

const closeShareModal = () => {
    showShareModal.value = false;
    selectedListId.value = null;
};

const handleListShared = () => {
    fetchLists();
};
// Fonction pour partager la liste
const shareList = async (index) => {
    const list = lists.value[index];
    if (list.selectedContacts.length > 0) {
        try {
            await axios.post(route('share-list'), {
                listId: list.id, // Utilisez l'ID réel de la liste
                contacts: list.selectedContacts,
            });
            alert('Liste partagée avec succès!');
            list.showContacts = false; // Masquer les contacts après le partage
        } catch (error) {
            console.error('Erreur lors du partage de la liste:', error);
        }
    } else {
        alert('Veuillez sélectionner au moins un contact.');
    }
};

// Charger les données au montage du composant
onMounted(() => {
    fetchTvDetails();
    fetchLists();
    fetchConnections();
});
</script>


<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tv show Details
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Première colonne : Détails de la série -->
                <div v-if="tv" class="text-gray-900 p-6 bg-white rounded-lg shadow">
                    <h1 class="text-lg font-semibold">{{ tv.name }}</h1>
                    <img v-if="tv.poster_path" :src="`https://image.tmdb.org/t/p/w500${tv.poster_path}`"
                        alt="TV Poster" />
                    <p>{{ tv.overview }}</p>
                    <p><strong>Première diffusion:</strong> {{ tv.first_air_date }}</p>
                    <p><strong>Nombre de saisons:</strong> {{ tv.number_of_seasons }}</p>
                </div>

                <!-- Deuxième colonne : Gestion des listes -->
                <div class="p-6 bg-white rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Créer une liste</h3>
                    <input v-model="listName" type="text" placeholder="Nom de la liste"
                        class="w-full px-4 py-2 border rounded mb-2" />
                    <button @click="createList"
                        class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Créer une nouvelle liste
                    </button>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Mes listes</h3>
                        <ul>
                            <li v-for="(list, index) in lists" :key="index" class="flex flex-col border-b py-2">
                                <div class="flex items-center justify-between">
                                    <span class="flex-1">{{ list.name }}</span>
                                    <div class="flex items-center space-x-2">
                                        <button @click="addToList(list.id)"
                                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                            ➕ Ajouter
                                        </button>
                                        <button @click="openShareModal(index)"
                                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Partager la liste
                                    </button>
                                </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Utilisation du composant ShareListModal -->
        <ShareListModal v-if="showShareModal" :listId="selectedListId" :activeConnections="activeConnections"
            @close="closeShareModal" @shared="handleListShared" />
    </AuthenticatedLayout>
</template>
