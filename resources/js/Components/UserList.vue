<template>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Vos listes</h1>

                <ul v-if="lists.length > 0">
                    <li v-for="list in lists" :key="list.id" class="border-b py-2">
                        {{ list.name }}
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

const lists = ref([]);

const fetchLists = async () => {
    try {
        const response = await axios.get(route('lists.index'));
        lists.value = response.data;
    } catch (error) {
        console.error('Erreur lors de la récupération des listes :', error);
    }
};

// Récupérer les listes dès que le composant est monté
onMounted(fetchLists);
</script>