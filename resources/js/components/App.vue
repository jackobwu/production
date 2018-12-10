<template>
<v-app id="inspire">
    
    <navbar />

    <v-content>
        <app-view></app-view>
    </v-content>
    
</v-app>
</template>

<script>
import Navbar from './Navbar/Navbar';

export default {
    components: {
        Navbar,
    },
    methods: {
        jwtErrorListener () {
            window.eventBus.$on('jwt-error', () => {
                this.$store.dispatch('logout');
                window.storage.set('url.intended', this.$route.fullPath);
                this.$router.push('/signin');
            });
        }
    },
    created () {
        this.jwtErrorListener();
    }
    
}
</script>
<style>

</style>


