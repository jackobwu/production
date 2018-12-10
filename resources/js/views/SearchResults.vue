<template>
    <v-container grid-list-md>
        <h1 class="title">你在查询"{{ keyword }}"</h1>
        <h4 class="subtitle has-text-grey">{{ users.length }} 结果</h4>
        <v-layout row warp v-for="user in users" :key="user.id">
            <user-block :user="user"></user-block>
        </v-layout>
    </v-container>
</template>

<script>
import UserBlock from '@/components/UserBlock';

export default {
    components: { UserBlock },
    data () {
        return {
            users: [],
            keyword: '',
            loading: true
        }
    },
    methods: {
        loadResults () {
            this.loading = true;
            this.users = [];
            this.keyword = this.$route.query.keyword;
            this.$http.get('/api/search', { params: { keyword: this.keyword } })
                .then(({ data }) => {
                    this.loading = false;
                    this.users = data;
                })
                .catch((error) => {
                    this.loading = false;
                    console.log(error.response);
                })
        }
    },
    created () {
        this.loadResults();
    },
    watch: {
        '$route.query.keyword' () {
            this.loadResults();
        }
    }
}
</script>

<style>

</style>
