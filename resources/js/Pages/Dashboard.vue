<script setup>
import SearchBar from '@/Components/SearchBar.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <SearchBar @results-updated="updateResults" />
                    </div>
                    <!-- Résultats -->
                    <div v-if="results && results.length > 0" class="mt-4">
                        <h2 class="text-lg font-bold">Search Results:</h2>
                        <ul>
                            <li v-for="(movie, index) in results" :key="index" class="py-2 border-b">
                                <div class="flex items-center">
                                    <img :src="`https://image.tmdb.org/t/p/w200${movie.poster_path}`" alt="Movie Poster"
                                        class="w-16 h-24 object-cover mr-4" />
                                    <div>
                                        <h3 class="font-semibold">{{ movie.title }}</h3>
                                        <p class="text-sm text-gray-600">
                                            Release Date: {{ movie.release_date || 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>

export default {
    components: {
        SearchBar,
    },
    data() {
        return {
            results: [], // Initialisation de la liste des résultats
        };
    },
    methods: {
        updateResults(newResults) {
            this.results = newResults; // Mise à jour des résultats avec ceux de SearchBar
        },
    },
};
</script>