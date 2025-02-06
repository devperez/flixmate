<template>

    <Head title="Liste" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                List details
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div v-if="list">
                    <h1 class="text-2xl font-bold mb-4">{{ list.name }}</h1>

                    <div v-if="list.items && list.items.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div v-for="item in list.items" :key="item.id" class="text-center">
                            <img v-if="item.movie" :src="'https://image.tmdb.org/t/p/w500' + item.movie.poster_path"
                            alt="Affiche du film" class="w-32 h-48 mx-auto rounded-lg shadow">
                            <p class="mt-2">{{ item.movie?.title }}</p>
                        </div>
                    </div>

                    <p v-else class="text-gray-500">Cette liste ne contient aucun film.</p>
                </div>
                <p v-else class="text-red-500">Chargement de la liste...</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    list: Object
});

</script>
