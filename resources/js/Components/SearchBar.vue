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
                const response = await fetch(
                    `https://api.themoviedb.org/3/search/movie?query=${encodeURIComponent(query)}`,
                    {
                        headers: {
                            accept: 'application/json',
                            Authorization: `Bearer ${import.meta.env.VITE_TMDB_TOKEN}`,
                        },
                    }
                );
                const data = await response.json();
                this.$emit("results-updated", data.results); // Émettre les résultats au parent
                //console.log(data.results);
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