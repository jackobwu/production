<template>
    <v-responsive v-if="$_auth.guest">

            <v-container grid-list-lg>
            <v-layout row wrap xs12 sm4>
                <v-flex>
                
                <v-card >
                <v-card-title primary-title>
                    <div class="subheadline">暂未开放注册，需要获得已经注册的好友邀请</div>
                    
                </v-card-title>

                </v-card>
                
                </v-flex>
            

            </v-layout>
            </v-container>

        </v-responsive>
</template>

<script>
export default {

}
</script>
