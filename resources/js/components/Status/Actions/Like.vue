<template>
    <div>
    <v-btn flat icon :color="color" @click="onClickLike" :disabled="!canLike">
        <v-icon small>favorite_border</v-icon>
        <small>
            {{ status.likes_count }}
        </small>
    </v-btn>
    </div>
</template>

<script>
export default {
    props: {
        status: {
            type: Object,
            required: true
        }
    },
    computed: {
        color () {
            return (this.status.liked ? 'red lighten-2' : '')
            
        },
        canLike () {
            return this.$_auth.check && this.status.of_friend
        }
    },
    methods: {
        onClickLike () {
            const requestType = (this.status.liked ? 'delete' : 'post');

            this.$http[requestType](`/api/statuses/${this.status.id}/likes`);
            this.$emit('like-toggled');
        }
    }

}
</script>

<style>

</style>
