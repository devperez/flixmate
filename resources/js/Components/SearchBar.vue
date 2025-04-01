<template>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md"
                        placeholder="Search..." v-model="query" @input="onSearch" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            query: '', // Stocke la valeur saisie par l'utilisateur
        };
    },
    
    methods: {
        onSearch() {
            if (this.query.length >= 3) {
                this.searchMovies(this.query);
            }
        },
        async searchMovies(query) {
            try {
                // Effectuer les requêtes pour les films et les séries en parallèle
                const [moviesResponse, tvResponse] = await Promise.all([
                    fetch(`https://api.themoviedb.org/3/search/movie?query=${encodeURIComponent(query)}`, {
                        method: "GET",
                        headers: {
                            accept: "application/json",
                            Authorization: `Bearer ${import.meta.env.VITE_TMDB_TOKEN}`,
                        },
                    }),
                    fetch(`https://api.themoviedb.org/3/search/tv?query=${encodeURIComponent(query)}`, {
                        method: "GET",
                        headers: {
                            accept: "application/json",
                            Authorization: `Bearer ${import.meta.env.VITE_TMDB_TOKEN}`,
                        },
                    }),
                ]);

                // Attendre les réponses JSON
                const moviesData = await moviesResponse.json();
                const tvData = await tvResponse.json();

                this.$emit('results-updated', {
                    movies: moviesData.results || [],
                    tvShows: tvData.results || [],
                });
            } catch (error) {
                console.error('Erreur lors de la recherche de films :', error);
                this.$emit("results-updated", []); // Émettre un tableau vide en cas d'erreur
            }
        },
    },
};
</script>

<style scoped>
/* Ajoutez des styles personnalisés ici si nécessaire */
</style>