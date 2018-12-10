<template>
    <v-layout>
    <v-autocomplete
        :loading="loading"
        :items="items"
        :search-input.sync="search"
        v-model="select"
        item-text="username"
        cache-items
        class="mx-3"
        hide-no-data
        hide-details
        label="查找朋友"
        solo
        clearable
        append-icon="search"
    >
        <template
        slot="item"
        slot-scope="{ item, tile }"
        >
            <v-list-tile-avatar
            color="indigo"
            class="headline font-weight-light white--text"
            >
            {{ item.username.charAt(0) }}
            </v-list-tile-avatar>
            <v-list-tile-content @click="onSelect(item.id)">
            <v-list-tile-title v-text="item.username"></v-list-tile-title>

            </v-list-tile-content>
            <v-list-tile-action>
            <v-icon class="">search</v-icon>
            </v-list-tile-action>
        </template>
    </v-autocomplete>
    </v-layout>
</template>

<script>
export default {
    data () {
        return {
            loading: false,
            items: [],
            search: '',
            select: '', 
        }
    },
    computed: {
        trimmedKeyword () {
            return this.search.trim();
        }
    },
    watch: {
        search (val) {
            val && val !== this.select && this.querySelections(val)
        }
    },
    methods: {
        querySelections (v) {
            this.loading = true
            // Simulated ajax query
            setTimeout(() => {
            this.$http.get('/api/search', { params: { keyword: this.trimmedKeyword } })
                .then(({ data }) => (this.items = data))
                .catch((error) => console.log(error.response));
            this.loading = false
            }, 800)
        },
        onSubmitSearch () {
            if (this.trimmedKeyword === '') return;

            this.$router.push({  path: '/search', query: {keyword: this.trimmedKeyword } });
            this.keyword = '';
        },
        onSelect (id) {
            this.$router.push(`/user/${id}`);
        },
    }
}
</script>
    
<style>

</style>
