<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <div class="home">
        <!-- En-tête avec Image de Fond -->
        <header class="relative bg-cover bg-center h-screen"
            style="background-image: url('/images/header.jpg');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative container mx-auto text-center text-white py-48">
                <nav class="absolute top-4 right-4 flex items-center space-x-4">
                    <Link :href="route('login')" class="text-white hover:text-gray-300">
                    Connexion
                    </Link>
                    <Link v-if="canRegister" :href="route('register')" class="text-white hover:text-gray-300">
                    Inscription
                    </Link>
                </nav>
                <h1 class="text-6xl font-bold mb-4 animate-fade-in">Bienvenue sur FlixMate</h1>
                <p class="text-2xl animate-fade-in delay-200">Gérez vos listes de films et séries, et discutez avec vos
                    amis !</p>
                <div class="mt-8 animate-bounce">
                    <svg class="w-12 h-12 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
                <!-- Captures d'Écran -->
                <div class="mt-12 flex flex-wrap justify-center gap-4 image-container">
                    <img src="/images/dashboard.png" alt="Capture d'écran 1"
                        class="image rounded-lg shadow-lg transform hover:scale-105 transition-transform">
                    <img src="/images/liste.png" alt="Capture d'écran 2"
                        class="image rounded-lg shadow-lg transform hover:scale-105 transition-transform">
                    <img src="/images/show.png" alt="Capture d'écran 3"
                        class="image rounded-lg shadow-lg transform hover:scale-105 transition-transform">
                </div>
            </div>
        </header>

        <!-- Section des Fonctionnalités -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto text-center">
                <h2 class="text-4xl font-bold mb-12">Fonctionnalités Principales</h2>
                <div class="flex flex-wrap justify-center">
                    <div class="w-full md:w-1/3 p-4 transform hover:scale-105 transition-transform">
                        <h3 class="text-2xl font-semibold mb-2">Listes Personnalisées</h3>
                        <p>Créez et gérez vos listes de films et séries préférés.</p>
                    </div>
                    <div class="w-full md:w-1/3 p-4 transform hover:scale-105 transition-transform">
                        <h3 class="text-2xl font-semibold mb-2">Chat Intégré</h3>
                        <p>Discutez avec vos amis directement sur la page de la liste.</p>
                    </div>
                    <div class="w-full md:w-1/3 p-4 transform hover:scale-105 transition-transform">
                        <h3 class="text-2xl font-semibold mb-2">Partage Facile</h3>
                        <p>Partagez vos listes avec vos contacts en un clic.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Témoignages -->
        <!-- <section class="py-20 bg-white">
            <div class="container mx-auto text-center">
                <h2 class="text-4xl font-bold mb-12">Ce que disent nos utilisateurs</h2>
                <div class="flex flex-wrap justify-center">
                    <div class="w-full md:w-1/3 p-4">
                        <p class="italic text-gray-700">"FlixMate a transformé ma façon de gérer mes listes de films !"
                        </p>
                        <p class="font-semibold mt-2">— Jean D.</p>
                    </div>
                    <div class="w-full md:w-1/3 p-4">
                        <p class="italic text-gray-700">"L'intégration du chat est géniale pour discuter des films avec
                            mes amis."</p>
                        <p class="font-semibold mt-2">— Marie L.</p>
                    </div>
                </div>
            </div>
        </section> -->

        <!-- Appel à l'Action -->
        <section class="py-20 bg-blue-500 text-white">
            <div class="container mx-auto text-center">
                <h2 class="text-4xl font-bold mb-4">Prêt à commencer ?</h2>
                <p class="mb-8 text-lg">Inscrivez-vous dès aujourd'hui et découvrez toutes les fonctionnalités de
                    FlixMate !</p>
                    <Link v-if="canRegister" :href="route('register')" class="bg-white text-blue-500 px-8 py-4 rounded-full font-semibold hover:bg-gray-100">
                    Inscription
                    </Link>
                <!-- <button class="bg-white text-blue-500 px-8 py-4 rounded-full font-semibold hover:bg-gray-100">
                    S'inscrire
                </button> -->
            </div>
        </section>

        <!-- Pied de Page -->
        <footer class="py-8 bg-gray-800 text-white">
            <div class="container mx-auto text-center">
                <p>&copy; 2025 FlixMate. Tous droits réservés.</p>
            </div>
        </footer>
    </div>
</template>


<style scoped>
@keyframes fade-in {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
        transform: translateY(0);
    }

    40% {
        transform: translateY(-30px);
    }

    60% {
        transform: translateY(-15px);
    }
}

.animate-fade-in {
    animation: fade-in 2s ease-in-out;
}

.animate-bounce {
    animation: bounce 2s infinite;
}

.image {
    width: 50%;
    height: auto;
    max-width: 500px;
}

.image-container {
    max-width: 100%;
    height: auto;
    margin-bottom: 2rem;
    object-fit: cover;
}
</style>
