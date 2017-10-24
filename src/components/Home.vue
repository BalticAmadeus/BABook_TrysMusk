<template lang="html">

        <v-container>
            <v-template row>
                <router-link to="/login"><v-btn round>Login</v-btn></router-link>
            </v-template>
        </v-container>

</template>

<script>
    export default {
    }
</script>

<style lang="scss" scoped>
    // Colors
    $babook-pink: #f80aaf;
    $babook-blue: #44ccff;
    $babook-green: #0af89d;
    $babook-violet: #8a02fa;
    $text-color: #9e9e9e;

    main{
        background-image: url("../assets/spaceAndLogo.jpg");
        background-position: center;
        background-size: cover;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
</style>

