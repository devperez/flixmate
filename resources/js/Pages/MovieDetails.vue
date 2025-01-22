<template>
    <div>
        <h1>Movie Details</h1>
        <p>Movie ID: {{ id }}</p>
        <!-- Tu peux ici appeler l'API de TMDB pour récupérer les détails du film -->
    </div>
</template>

<script>
export default {
    props: {
        id: String,
    },
};
</script>