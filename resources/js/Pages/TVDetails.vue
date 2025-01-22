<template>
    <div>
        <h1>TV Show Details</h1>
        <p>TV Show ID: {{ id }}</p>
        <!-- Appel à l'API de TMDB pour afficher les détails de la série -->
    </div>
</template>

<script>
export default {
    props: {
        id: String,
    },
};
</script>