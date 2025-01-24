<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1>{{ tv.name }}</h1>
                <img :src="`https://image.tmdb.org/t/p/w500${tv.poster_path}`" alt="TV Poster" />
                <p>{{ tv.overview }}</p>
                <p><strong>First Air Date:</strong> {{ tv.first_air_date }}</p>
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