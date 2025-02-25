<template>

    <Head title="Liste" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                List details
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-end">
                    <button @click="openShareModal(index)"
                        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Partager la liste
                    </button>
                </div>
                <div v-if="list">
                    <h1 class="text-2xl font-bold mb-4">{{ list.name }}</h1>
                    <div v-if="list.items && list.items.length > 0"
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div v-for="item in list.items" :key="item.id"
                            class="border rounded-lg shadow-md p-4 text-center">
                            <img v-if="item.movie" :src="'https://image.tmdb.org/t/p/w500' + item.movie.poster_path"
                                alt="Affiche du film" class="w-full h-auto rounded-lg shadow mb-4">
                            <p class="text-lg font-semibold">{{ item.movie?.title }}</p>
                        </div>
                    </div>
                    <p v-else class="text-gray-500">Cette liste ne contient aucun film.</p>
                </div>

                <p v-else class="text-red-500">Chargement de la liste...</p>
            </div>
        </div>
        <!-- Utilisation du composant ShareListModal -->
        <ShareListModal v-if="showShareModal" :listId="list?.id" :activeConnections="activeConnections"
            @close="closeShareModal" @shared="handleListShared" />
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ShareListModal from '@/Components/ShareListModal.vue';
import { ref, onMounted } from 'vue';

const showShareModal = ref(false);
const activeConnections = ref([]);
const props = defineProps({
    list: {
        Object,
        required: true
    }
});

const openShareModal = () => {
    showShareModal.value = true;
};

const closeShareModal = () => {
    showShareModal.value = false;
};

const handleListShared = () => {
    alert('Liste partagée avec succès!');
};

// Fonction pour partager la liste
const shareList = async (index) => {
    if (list.selectedContacts.length > 0) {
        try {
            await axios.post(route('share-list'), {
                listId: props.list.id, // Utilisez l'ID réel de la liste
                contacts: list.selectedContacts,
            });
            alert('Liste partagée avec succès!');
            //list.showContacts = false; // Masquer les contacts après le partage
            closeShareModal();
        } catch (error) {
            console.error('Erreur lors du partage de la liste:', error);
        }
    } else {
        alert('Veuillez sélectionner au moins un contact.');
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

// Charger les données au montage du composant
onMounted(() => {
    //fetchLists();
    fetchConnections();
});

</script>
