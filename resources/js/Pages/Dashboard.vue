<script setup>
import SearchBar from '@/Components/SearchBar.vue';
import UserList from '@/Components/UserList.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <!-- Conteneur principal en grid à 4 colonnes sur grand écran -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-4 gap-6">

                <!-- Colonne de gauche : occupe 3 colonnes -->
                <div class="lg:col-span-3">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <!-- Barre de recherche -->
                        <div class="p-6 text-gray-900">
                            <SearchBar @results-updated="updateResults" />
                        </div>

                        <!-- Affichage des films -->
                        <div v-if="movies && movies.length > 0" class="mt-4 p-6">
                            <h2 class="text-lg font-bold mb-4">Movies:</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div v-for="(movie, index) in movies" :key="index"
                                    class="border border-gray-300 rounded-md shadow-sm overflow-hidden">
                                    <Link :href="route('tv.details', { id: movie.id, type: 'movie' })">
                                    <img :src="`https://image.tmdb.org/t/p/w200${movie.poster_path}`" alt="Movie Poster"
                                        class="w-full h-auto" />
                                    </Link>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-center">{{ movie.title }}</h3>
                                        <p class="text-sm text-gray-600 text-center">
                                            Release Date: {{ movie.release_date || 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Affichage des séries TV -->
                        <div v-if="tvShows && tvShows.length > 0" class="mt-8 p-6">
                            <h2 class="text-lg font-bold mb-4">TV Shows:</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                <div v-for="(tvShow, index) in tvShows" :key="index"
                                    class="border border-gray-300 rounded-md shadow-sm overflow-hidden">
                                    <Link :href="route('tv.details', { id: tvShow.id, type: 'tv' })">
                                    <img :src="`https://image.tmdb.org/t/p/w200${tvShow.poster_path}`"
                                        alt="TV Show Poster" class="w-full h-auto" />
                                    </Link>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-center">{{ tvShow.name }}</h3>
                                        <p class="text-sm text-gray-600 text-center">
                                            First Air Date: {{ tvShow.first_air_date || 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne de droite : occupe 1 colonne -->
                <div class="lg:col-span-1">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                        <UserList />
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
            movies: [],
            tvShows: [],
        };
    },
    methods: {
        updateResults({ movies, tvShows }) {
            this.movies = movies;
            this.tvShows = tvShows;
        },
    },
};
</script>