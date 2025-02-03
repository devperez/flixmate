<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const listName = ref('');
const lists = ref([]);

// Récupérer les listes au chargement
const fetchLists = async () => {
    try {
        const response = await axios.get(route('lists.index'));
        lists.value = response.data;
    } catch (error) {
        console.error('Erreur lors de la récupération des listes:', error);
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
        }, {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        lists.value.push(response.data);
        listName.value = ''; // Réinitialiser le champ après création
    } catch (error) {
        console.error('Erreur lors de la création de la liste:', error);
    }
};

// Charger les listes au montage
onMounted(fetchLists);
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tv show Details
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Première colonne : Détails de la série -->
                <div>
                    <h1>{{ tv.name }}</h1>
                    <img :src="`https://image.tmdb.org/t/p/w500${tv.poster_path}`" alt="TV Poster" />
                    <p>{{ tv.overview }}</p>
                    <p><strong>Première diffusion:</strong> {{ tv.first_air_date }}</p>
                    <p><strong>Nombre de saisons:</strong> {{ tv.number_of_seasons }}</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Créer une liste</h3>
                    <input v-model="listName" type="text" placeholder="Nom de la liste"
                        class="w-full px-4 py-2 border rounded mb-2" />
                    <button @click="createList"
                        class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Ajouter la liste
                    </button>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Mes listes</h3>
                        <ul>
                            <li v-for="(list, index) in lists" :key="index" class="border-b py-2">
                                {{ list.name }}
                            </li>
                        </ul>
                    </div>

                    <button @click="shareList"
                        class="mt-4 w-full bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Partager la liste
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    props: {
        id: String,
    },
    data() {
        return {
            tv: null,
        };
    },
    async created() {
        await this.fetchTvDetails();
    },
    methods: {
        async fetchTvDetails() {
            try {
                const response = await fetch(
                    `https://api.themoviedb.org/3/tv/${this.id}`,
                    {
                        headers: {
                            accept: 'application/json',
                            Authorization: `Bearer ${import.meta.env.VITE_TMDB_TOKEN}`,
                        },
                    }
                );
                const data = await response.json();
                console.log(data);
                this.tv = data;
            } catch (error) {
                console.error('Erreur lors de la récupération des détails de la série :', error);
            }
        },
    },
    
};
</script>