<template>
    <v-container fluid grid-list-xl>
    <v-layout row wrap>
    <v-flex xs12 sm12 md6 offset-md3
        v-for="request in requests" :key="request.id"
    >
    <v-card>  
    <v-card-text>
        <div class="layout ma-0 align-center row">
        <v-btn icon large flat slot="activator" :to="profile(request)">
        <v-avatar size="48" color="primary">
            <img :src="`/storage/${request.avatar}`">
        </v-avatar>
        </v-btn>
        <div class="flex text-xs-right">
            <div class="subheading">{{ request.username }}</div>
        </div>
        </div>
    </v-card-text>
    </v-card>
    </v-flex>
    
    </v-layout>
</v-container>
</template>

<script>
import { profile } from '@/util/mixins';

export default {
    mixins: [profile],
    data () {
        return {
            requests: [],
        }
    },
    created () {
        this.$http.get('/api/friendships')
            .then(({ data }) => {
                this.requests = data.requests;
            })
            .catch((error) => {
                console.log(error.response);
            })
    }
}
</script>

<style>

</style>
