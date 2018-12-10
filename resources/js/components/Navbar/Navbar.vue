<template>
    <div>
        <v-navigation-drawer 
        v-if="$_auth.check"
        clipped
        v-model="drawer"
        fixed
        app
        >
        <v-list>
            <v-list-tile>
            <v-list-tile-content class="text-xs-center">
            <v-list-tile-title class="grey--text text--darken-1 title">
                有朋
            </v-list-tile-title>
            </v-list-tile-content>
            </v-list-tile>
        </v-list>
    
        <v-list>

            <search-bar class="hidden-md-and-up" mt2/>
        </v-list>
        <v-list>

        <v-list-tile to="/">
        <v-list-tile-action>
            <v-icon medium>home</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
            <v-list-tile-title class="grey--text text--darken-1">
                首页
            </v-list-tile-title>
        </v-list-tile-content>
        </v-list-tile>
        <v-list-group

            prepend-icon="supervisor_account"
        >

        <v-list-tile  slot="activator">
        <!-- <v-list-tile-action>
            <v-icon medium>supervisor_account</v-icon>
        </v-list-tile-action> -->
        <!-- <v-list-tile-content> -->
            <v-list-tile-title class="grey--text text--darken-1">
                我的好友
            </v-list-tile-title>
        <!-- </v-list-tile-content> -->
        </v-list-tile>
        
            <v-list-tile to="/friends">
                <v-list-tile-action>
                    <v-icon></v-icon>
                </v-list-tile-action>
                <v-list-tile-title class="grey--text text--darken-1">好友列表</v-list-tile-title>
            </v-list-tile>

            <v-list-tile to="/friends/request">
                <v-list-tile-action>
                    <v-icon></v-icon>
                </v-list-tile-action>
                <v-list-tile-title class="grey--text text--darken-1">好友请求</v-list-tile-title>
            </v-list-tile>
        </v-list-group>
        <v-list-tile :to="profile($_auth.user)">
        <v-list-tile-action>
            <v-icon color="grey darken-1" light medium>account_box</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
            <v-list-tile-title class="grey--text text--darken-1">
                我的主页
            </v-list-tile-title>
        </v-list-tile-content>
        </v-list-tile>
        <v-list-tile to="/invite">
        <v-list-tile-action>
            <v-icon color="grey darken-1" medium>alternate_email</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
            <v-list-tile-title class="grey--text text--darken-1">
                邀请好友
            </v-list-tile-title>
        </v-list-tile-content>
        </v-list-tile>
    </v-list>
    </v-navigation-drawer>
    <v-toolbar color="white" app fixed clipped-left>
    <v-toolbar-side-icon v-if="$_auth.check" @click.native="drawer = !drawer"></v-toolbar-side-icon>
    <v-icon>fas fa-adjust</v-icon>
    <v-btn to="/" flat v-if="$_auth.guest" class="headline primary--text">有朋</v-btn>
        <search-form v-if="$_auth.check" class="hidden-sm-and-down"/>

        <v-spacer></v-spacer>
        <v-btn small v-if="$_auth.guest" color="primary" flat to="/signin" >
        <!-- <v-icon color="primary">account_box</v-icon> -->
            登录  
        </v-btn>
        <v-btn small v-if="$_auth.guest" color="primary" flat to="/register" >
        <!-- <v-icon color="primary" >how_to_reg</v-icon> -->
            注册   
        </v-btn>
        
        <v-menu v-if="$_auth.check" offset-y origin="center center" transition="slide-y-transition">
            <v-btn icon large flat slot="activator">
            <v-avatar v-if="$_auth.user.avatar" size="30px">
                <img :src="userAvatar">
            </v-avatar>
            <v-avatar v-else size="30px">
                <img src="@/img/avatar.svg">
            </v-avatar>
            </v-btn>
            <v-list>
            <v-list-tile to="/profile/edit">
                <v-list-tile-action>
                <v-icon>account_circle</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                <v-list-tile-title>修改资料</v-list-tile-title>
                </v-list-tile-content>   
            </v-list-tile>
            </v-list>
            <v-list>
            <v-list-tile to="/password/change">
                <v-list-tile-action>
                <v-icon>lock</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                <v-list-tile-title>修改密码</v-list-tile-title>
                </v-list-tile-content>   
            </v-list-tile>
            </v-list>
            <v-list>
            <v-list-tile @click="onClickSignout">
                <v-list-tile-action >
                <v-icon>fullscreen_exit</v-icon>
                </v-list-tile-action>
                <v-list-tile-content>
                <v-list-tile-title>登出</v-list-tile-title>
                </v-list-tile-content>   
            </v-list-tile>
            </v-list>
        </v-menu>
        </v-toolbar>
    </div>
</template>

<script>
import SearchForm from './SearchForm';
import SearchBar from './SearchBar';
import { profile } from '@/util/mixins';

export default {
    components: { SearchForm, SearchBar },
    mixins: [profile],
    data: () => ({
        drawer: null
    }),
    computed: {
        userAvatar () {
            return `/storage/${ this.$_auth.user.avatar }`;
        },
    },
    methods: {
        onClickSignout () {
            this.$http.post('/api/logout')
                .then((Response) => {
                    this.$store.dispatch('logout');
                    this.$router.push('/');
                })
                .catch((error) => console.log(error.response));
        }
    }
}
</script>


