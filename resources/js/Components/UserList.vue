<template>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Vos listes</h1>

                <ul v-if="lists.length > 0">
                    <li v-for="list in lists" :key="list.id" class="border-b py-4 text-center">
                        <h2 class="text-lg font-semibold mb-2">{{ list.name }} ({{ list.items.length }})</h2>

                        <div v-if="list.items.length > 0 && list.items[0].movie && list.items[0].movie.poster_path" class="flex justify-center">
                            <Link :href="`/lists/${list.id}`">
                                <img :src="'https://image.tmdb.org/t/p/w500' + list.items[0].movie.poster_path"
                                alt="Affiche du film" class="w-32 h-48 rounded-lg shadow">
                            </Link>
                        </div>

                        <p v-else class="text-gray-500">Aucun film dans cette liste.</p>
                    </li>
                </ul>

                <p v-else class="text-gray-500">Aucune liste trouvée.</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

const lists = ref([]);

const fetchLists = async () => {
    try {
        const response = await axios.get(route('lists.index'));
        lists.value = response.data;
        //console.log(lists.value)
    } catch (error) {
        console.error('Erreur lors de la récupération des listes :', error);
    }
};

defineProps({
    lists: Array
});

// Récupérer les listes dès que le composant est monté
onMounted(fetchLists);
</script>