<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Movie details
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1>{{ movie.title }}</h1>
                <img :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" alt="Movie Poster" />
                <p>{{ movie.overview }}</p>
                <p><strong>Release Date:</strong> {{ movie.release_date }}</p>
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
            movie: null,
        };
    },
    async created() {
        await this.fetchMovieDetails();
    },
    methods: {
        async fetchMovieDetails() {
            try {
                const response = await fetch(
                    `https://api.themoviedb.org/3/movie/${this.id}`,
                    {
                        headers: {
                            accept: 'application/json',
                            Authorization: `Bearer ${import.meta.env.VITE_TMDB_TOKEN}`,
                        },
                    }
                );
                const data = await response.json();
                this.movie = data;
            } catch (error) {
                console.error('Erreur lors de la récupération des détails du film :', error);
            }
        },
    },
};
</script>