<template>
    <v-flex md6 offset-md3 sm12 xs12>
        <v-card>
            <v-card-text>
                <v-layout row justify-space-between wrap>
                    <v-flex xs2 sm2 md2>
                    <v-btn icon large flat slot="activator" :to="profile(user)">
                    <v-avatar v-if="user.avatar" size="50px">
                        <img :src="userProfile">
                    </v-avatar>
                    <v-avatar v-else size="50px">
                        <img src="@/img/avatar.svg">
                    </v-avatar>
                    </v-btn>
                    </v-flex>
                    <v-flex>
                        <p >{{ user.username }}</p>  
                    </v-flex>  
                </v-layout>
                <p v-if="status != null">
                {{ status.body }} 
                </p>
            </v-card-text>
            <v-img v-if="status.image" :src="statusImage" height="350"/>

            <v-list v-if="showReplies" three-line>
                <template v-for="reply in replies">
                <v-list-tile :key="reply.id">
                    <v-list-tile-avatar>
                        <img :src="reply.user.avatar">
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-title>{{ reply.user.username }}</v-list-tile-title>
                        <v-list-tile-sub-title>{{ reply.body }}</v-list-tile-sub-title>
                    </v-list-tile-content>  
                </v-list-tile>
                </template>
            </v-list>
            <v-card-actions>
                <v-spacer></v-spacer>
                
                <like :status="status" @like-toggled="onLikeToggled"/>
                
                <reply :status="status" :parentId="status.id"/>

                <v-btn icon @click="fetchReplies">
                    <v-icon small>unfold_more</v-icon>
                </v-btn>      
            </v-card-actions>
            
        </v-card>
        
    </v-flex>   
</template>

<script>
import Like from './Actions/Like';
import Reply from './Actions/Reply';
import { profile } from '@/util/mixins';

export default {
    components: { Like, Reply },
    mixins: [profile],
    data () {
        return {
            bottomNav: 'recent',
            replies: [],
            showReplies: false
        }
    },
    props: {
        status: {
            type: Object,
            required: true
        }
    },
    computed: {
        user () {
            return this.status.user;
        },
        isMyStatus () {
            return this.$_auth.check && this.user.id === this.$_auth.id;
        },
        canReply () {
            return (this.isMyStatus || this.status.of_friend) && !this.status.parent_id;
        },
        statusImage () {
            return `/storage/${this.status.image}`;
        },
        userProfile () {
            return `/storage/${ this.status.user.avatar }`;
        }
        
    },
    methods: {
        onLikeToggled () {
            this.status.likes_count += (this.status.liked ? -1 : 1);
            this.status.liked = !this.status.liked;
        },
        fetchReplies () {
            this.$http.get(`/api/statuses/${this.status.id}/replies`)
                .then(({ data }) => {
                    this.showReplies = true;
                    this.replies = data.reverse();
                }) 
                .catch((error) => {
                    console.log(error.response);
                })
        },
    }  
}
</script>

<style>

</style>
