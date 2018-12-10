<template>
    <div id="Home">
        <feed 
            v-if="$_auth.check"
            endpoint="/api/statuses"
            >
        </feed>
        
    
        <v-responsive v-if="$_auth.guest">

            <v-container grid-list-lg>
            <v-layout row wrap xs12 sm4>
                <v-flex>
                
                <v-card >
                <v-card-title primary-title>
                    <div class="headline">欢迎来到有朋</div>
                    
                </v-card-title>
                <v-card-text>
                    <div>一 目前还是测试版本，但是已经可以体验一些核心功能.</div>
                    <div>二 app采用实名制，请大家都用真实姓名注册，否则可能无法使用一些核心功能.</div>
                    <div>三 版本会持续迭代，也希望大家在使用的过程中，针对具体的功能提一些建议.</div>
                </v-card-text>
                <v-card-actions>
                    <p>建议请发送邮件到：jackob_wu@gmail.com</p>
                </v-card-actions>
                </v-card>
                
                </v-flex>
            

            </v-layout>
            </v-container>

        </v-responsive>
    
    </div>
</template>

<script>
import Feed from '@/components/Feed';


export default {
    components: { Feed }
}
</script>

<style>

</style>
