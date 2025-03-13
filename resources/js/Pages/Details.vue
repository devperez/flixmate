<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import ShareListModal from '@/Components/ShareListModal.vue';

// Récupérer l'ID depuis les props
const props = defineProps(['id', 'type']);

// Références réactives
const listName = ref('');
const lists = ref([]);
const tv = ref(null);
const activeConnections = ref([]);
const selectedListId = ref(null);
const showShareModal = ref(false);
const movie = ref(null);
const sharedContacts = ref([]);
const currentUserId = ref(null);

const sharedContactIds = computed(() => {
    return sharedContacts.value.map(contact => contact.id);
});

//console.log(props.type);
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
        //console.log(tv.value);
    } catch (error) {
        console.error('Erreur lors de la récupération des détails de la série :', error);
    }
};
//Récupérer les détails du film depuis TMDb
const fetchMovieDetails = async () => {
    try {
        const response = await fetch(
            `https://api.themoviedb.org/3/movie/${props.id}`,
            {
                headers: {
                    accept: 'application/json',
                    Authorization: `Bearer ${import.meta.env.VITE_TMDB_TOKEN}`,
                },
            }
        );
        const data = await response.json();
        movie.value = data;
        //console.log(movie.value);
    } catch (error) {
        console.error('Erreur lors de la récupération des détails du film :', error);
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
    //console.log(movie.value);
    if (tv.value) {
        try {
            await axios.post(route('lists.add_movie', { list: listId }), {
                tv_id: tv.value.id, // On envoie l'id de la série
                name: tv.value.name, // On récupère le nom
                poster: tv.value.poster_path,
                release: tv.value.first_air_date,
                metadata: 'tv',
            });
            fetchLists();
            alert(`"${tv.value.name}" ajouté à la liste !`);
        } catch (error) {
            console.error('Erreur lors de l\'ajout à la liste:', error);
        }
    } if (movie.value) {
        //console.log(movie.value);
        try {
            await axios.post(route('lists.add_movie', { list: listId }), {
                movie_id: movie.value.id,
                title: movie.value.title,
                poster: movie.value.poster_path,
                release: movie.value.release_date,
                metadata: 'movie',
            });
            fetchLists();
            alert(`"${movie.value.title}" ajouté à la liste !`);
        } catch (error) {
            console.error('Erreur lors de l\'ajout à la liste:', error);
        }
    };
};

const openShareModal = (index) => {
    selectedListId.value = lists.value[index].id;
    fetchSharedContacts(selectedListId.value);
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

const isInList = (items) => {
    if (!Array.isArray(items)) {
        return false;
    }

    if (!tv.value && !movie.value) {
        return false;
    }

    return items.some(item => item.movie?.tmdb_id === tv.value?.id || item.movie?.tmdb_id === movie.value?.id);
};

const removeFromList = (listId) => {
    //console.log(movie.value.id);
    try {
        axios.delete(route('delete-movie', { list: listId, movie: tv.value.id ? tv.value.id : movie.value.id }));
        alert(`"${tv.value.name}" supprimé de la liste !`);
        fetchLists();
    } catch (error) {
        console.error('Erreur lors de la suppression de la série de la liste:', error);
    }
};

// Fonction pour récupérer les contacts avec lesquels la liste est déjà partagée
const fetchSharedContacts = async (selectedListId) => {
    //console.log(selectedListId);
    try {
        const response = await axios.get(route('lists.sharedContacts', { listId: selectedListId }));
        sharedContacts.value = response.data.sharedContacts;
    } catch (error) {
        console.error('Erreur lors de la récupération des contacts partagés:', error);
    }
};

// Fonction pour récupérer l'ID de l'utilisateur actuel
const fetchCurrentUserId = async () => {
    try {
        const response = await axios.get(route('current-user'));
        currentUserId.value = response.data.id;
    } catch (error) {
        console.error('Erreur lors de la récupération de l\'ID de l\'utilisateur actuel:', error);
    }
};

// Charger les données au montage du composant
onMounted(() => {
    if (props.type === 'tv') {
        fetchTvDetails();
    } else {
        fetchMovieDetails();
    }
    fetchLists();
    fetchConnections();
    fetchCurrentUserId();
});
</script>


<template>
    <AuthenticatedLayout>
        <template #header>
            <div v-if="movie" class="flex flex-col items-center space-y-4 p-6 bg-white rounded-lg shadow">
                <!-- Titre et genres -->
                <div class="flex flex-wrap items-center space-x-2">
                    <h1 class="text-2xl font-bold text-gray-800">{{ movie.title }}</h1>
                    <span v-for="(genre, index) in movie.genres" :key="index"
                        class="text-sm font-medium text-gray-600 bg-gray-200 rounded-full px-3 py-1">
                        {{ genre.name }}
                    </span>
                </div>

                <!-- Tagline -->
                <div class="text-lg italic text-center text-gray-500">
                    "{{ movie.tagline }}"
                </div>
            </div>
            <div v-if="tv" class="flex flex-col items-center space-y-4 p-6 bg-white rounded-lg shadow">
                <!-- Titre et genres -->
                <div class="flex flex-wrap items-center justify-center space-x-2">
                    <h1 class="text-2xl font-bold text-gray-800">{{ tv.name }}</h1>
                    <span v-for="(genre, index) in tv.genres" :key="index"
                        class="text-sm font-medium text-gray-600 bg-gray-200 rounded-full px-3 py-1">
                        {{ genre.name }}
                    </span>
                </div>

                <!-- Tagline -->
                <div class="text-lg italic text-center text-gray-500">
                    "{{ tv.tagline }}"
                </div>
            </div>

        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Première colonne : Détails de la série -->
                <div v-if="tv" class="text-gray-900 p-6 bg-white rounded-lg md:col-span-1 shadow">
                    <img v-if="tv.poster_path" :src="`https://image.tmdb.org/t/p/w500${tv.poster_path}`"
                        alt="TV Poster" />
                    <p class="py-2">{{ tv.overview }}</p>
                    <p><strong>Première diffusion:</strong> {{ tv.first_air_date }}</p>
                    <p><strong>Nombre de saisons:</strong> {{ tv.number_of_seasons }}</p>
                    <p><strong>Nombre d'épisodes:</strong> {{ tv.number_of_episodes }}</p>
                    <p><strong>Statut:</strong> {{ tv.status }}</p>
                </div>
                <!-- Première colonne : Détails du film -->
                <div v-if="movie" class="text-gray-900 p-6 bg-white rounded-lg md:col-span-1 shadow">
                    <img :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" alt="Movie Poster" />
                    <p class="py-2">{{ movie.overview }}</p>
                    <p><strong>Sortie:</strong> {{ movie.release_date }}</p>
                    <p><strong>Durée:</strong> {{ movie.runtime }}</p>
                </div>

                <!-- Deuxième colonne : Gestion des listes -->
                <div class="p-6 bg-white rounded-lg shadow md:col-span-2">
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
                                    <button @click="destroyList(list.id)"
                                        class="px-1 py-2 mx-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <button @click="openShareModal(index)"
                                        class="px-1 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                        </svg>

                                    </button>
                                    <span class="flex-1 px-2">{{ list.name }}</span>
                                    <div class="flex items-center space-x-1">
                                        <button @click="addToList(list.id)"
                                            class="bg-green-500 text-white px-1 py-2 rounded hover:bg-green-600">
                                            ➕ Ajouter à cette liste
                                        </button>
                                        <button v-if="isInList(list.items)" @click="removeFromList(list.id)"
                                            class="bg-red-500 text-white px-1 py-2 rounded hover:bg-red-600">
                                            🗑 Retirer de cette liste
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
        <!-- <ShareListModal v-if="showShareModal" :listId="selectedListId" :activeConnections="activeConnections"
            @close="closeShareModal" @shared="handleListShared" /> -->
            <ShareListModal v-if="showShareModal" :listId="selectedListId" :activeConnections="activeConnections" :sharedContacts="sharedContactIds"
            :ownerId="selectedListId?.owner_id" :currentUserId="currentUserId" @close="closeShareModal" @shared="handleListShared" />
    </AuthenticatedLayout>
</template>
