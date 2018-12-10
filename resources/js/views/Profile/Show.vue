<template>
    <div class="profile page">
        <v-container fluid grid-list-lg>
            <v-layout row wrap>
                <v-flex xs12>
                <div class="layout mt-2 align-center column">
                    <v-avatar size="192">
                        <img v-if="user.avatar" :src="userAvatar">
                        <img v-else src="/images/avatar.svg">
                    </v-avatar>
                </div>
            </v-flex>
            <v-flex xs12>
                <p class="layout mt-1  align-center column subheading">{{ user.username }}</p>
                <p v-if="user.introduction" class="text-xs-center mx-2">
                    道可道，非常道，名可名，非常名
                </p>
                <div class="layout mt-2 justify-space-around">
                    <v-btn v-if="showButton" color="primary" to="/profile/edit">修改个人资料</v-btn>
                </div>
                <div class="layout mt-2 justify-space-around">
                    <friendship :friendship.sync="friendship" :user="user"/>
                    <v-btn v-if="!showButton" color="success">私信</v-btn>
                </div>
            </v-flex>
            <v-flex xs12>
                <v-card v-if="user.education || user.career || user.location">
                    <v-list>
                        <v-list-tile v-if="user.education">
                            <v-list-tile-content>
                            <v-list-tile-title>教育经历</v-list-tile-title>
                            <v-list-tile-sub-title>厦门大学</v-list-tile-sub-title>
                            </v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile v-if="user.career">   
                            <v-list-tile-content>
                            <v-list-tile-title>职业经历</v-list-tile-title>
                            <v-list-tile-sub-title>厦门建发集团</v-list-tile-sub-title>
                            </v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile v-if="user.location">
                            <v-list-tile-content>
                            <v-list-tile-title>所在地</v-list-tile-title>
                            <v-list-tile-sub-title>旧金山</v-list-tile-sub-title>
                            </v-list-tile-content>
                        </v-list-tile>
                        </v-list>
                </v-card>
                
            </v-flex>
    </v-layout>
    </v-container>
        <feed 
            v-if="$_auth.check"
            endpoint="/api/statuses"
            >
        </feed>
    
    </div>
</template>

<script>
import Feed from '@/components/Feed';
import Friendship from '@/components/Friendship';
import { removeById } from '@/util/helpers';

export default {
    components: {
        Feed,
        Friendship
    },
    data () {
        return {
            user: {},
            friends: [],
            friends_total: 0,
            friendship: ''
        }
    },
    computed: {
        showButton () {
            return this.user.id === this.$_auth.id 
        },
        userAvatar () {
            return `/storage/${ this.user.avatar }`;
        },
    },
    
    methods: {
        loadProfile () {
            this.user = {};
            this.$http.get(`/api/profile/${this.$route.params.id}`)
                .then(({ data }) => {
                    this.user = data.user;
                    this.friends = data.friends;
                    this.friends_total = data.friends_total;
                    this.friendship = data.friendship;
                })
                .catch((error) => {
                    console.log(error.response);
                    if (error.response.status === 404) {
                        this.$_error(404);
                    }
                });
        }
    },
    created () {
        this.loadProfile();
    },
    watch: {
        friendship (current, old) {
            const change = `${old} > ${current}`;
            if (change === 'friends > not_friends') {
                this.friends_total--;
                removeById(this.friends, this.$_auth.id);
            } else if (change === 'pending > friends') {
                this.friends_total++;
                this.friends.unshift(this.$_auth.user);
            }
        },
        '$route.params.id' () {
            this.loadProfile();
        }
    }
}
</script>

<style>

</style>
