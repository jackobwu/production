<template>
<v-container fluid grid-list-xl>
    <v-layout row wrap>
    <v-flex xs12 sm12 md6 offset-md3
        v-for="friend in friends" :key="friend.id"
    >
    <v-card >  
    <v-card-text>
        <div class="layout ma-0 align-center row">
        <v-btn icon large flat slot="activator" :to="profile(friend)">
        <v-avatar size="48" color="primary">
            <img :src="friend.avatar" >
        </v-avatar>
        </v-btn>
        <div class="flex text-xs-right">
            <div class="subheading">{{ friend.username }}</div>
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
            friends: [],
        };
    },
    created () {
        this.$http.get('/api/friendships')
            .then(({ data }) => {
                this.friends = data.friends;
            })
            .catch((error) => {
                console.log(error.response);
            })
    }

}
</script>

<style>

</style>
