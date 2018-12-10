<template>
    <div v-infinite-scroll="fetchStatuses" infinite-scroll-disabled="disabled">    
        <v-container fluid grid-list-lg>
            <v-layout row wrap>          
                <template v-if="statuses.length">
                    <status
                        v-for="status in statuses"
                        :status="status"
                        :key="status.id"
                        >
                    </status>
                </template>

                <status-form
                    @status-posted="onStatusPosted"
                    >
                </status-form>
            </v-layout>
        </v-container> 
    </div>
</template>

<script>
import infiniteScroll from 'vue-infinite-scroll';
import Status from './Status/Status';
import StatusForm from './Status/StatusForm';

export default {
    components: { Status, StatusForm },
    directives:{ infiniteScroll },
    data () {
        return {
            statuses: [],
            cursor: null,
            loading: false,
            last: false
        }
    },
    props: {
        endpoint: {
            type: String,
            required: true
        },
        empty: {
            type: String,
            default: 'No statuses yet.'
        }
    },
    computed: {
        disabled () {
            return this.loading || this.last;
        }
        
    },
    methods: {
        fetchStatuses () {
            this.loading = true;
            this.$http.get(this.endpoint, {
                params: { cursor: this.cursor }
            })
                .then(({ data }) => {
                    this.loading = false;
                    this.statuses = this.statuses.concat(data.records);
                    this.cursor = (data.has_next ? data.next_cursor.id : null);
                    this.last = !data.has_next;
                })
                .catch((error) => {
                    setTimeout(() => (this.loading = false), 1000);
                    console.log(error.response);
                });
        },
        onStatusPosted (status) {
            this.statuses.unshift(status);

        },
        onStatusDeleted (id) {
            removeById(this.statuses, id);
        }
    }
}
</script>

<style>
.is-invisible {
    display: none
}

</style>
