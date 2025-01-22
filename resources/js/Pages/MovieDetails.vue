<template>
    <div>
        <h1>{{ movie.title }}</h1>
        <img :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`" alt="Movie Poster" />
        <p>{{ movie.overview }}</p>
        <p><strong>Release Date:</strong> {{ movie.release_date }}</p>
    </div>
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