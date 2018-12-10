<template>
    <v-flex xs12 sm12 md6 offset-md3>
        <v-card >  
        <v-card-text>
            <div class="layout ma-0 align-center row">
            <v-avatar size="48" color="primary">
                <img src="@/img/man_2.jpg" >
            </v-avatar>
            <div class="flex text-xs-right">
                <div class="subheading">{{ user.username }}</div>
                <span class="caption">jobTitle</span>
            </div>
            </div>
        </v-card-text>
        </v-card>
    </v-flex>
</template>

<script>
export default {
    props: {
        user: {
            type: Object,
            required: true
        }
    } 
}
</script>

<style>

</style>
