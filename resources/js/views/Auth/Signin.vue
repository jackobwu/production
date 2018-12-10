<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4 lg4>
            <v-card >
            <v-card-text>
                <div class="layout column align-center">
                <!-- <img src="#" alt="Vue Material Admin" width="120" height="120"> -->
                <h1 class="flex my-4">登 录</h1>
                </div>                
                <v-form ref="form" v-model="valid" lazy-validation >
                    <v-text-field 
                        prepend-icon="email" 
                        label="邮箱" 
                        type="text" 
                        v-model="email"
                        :rules="emailRules"
                        ></v-text-field>
                    <v-text-field 
                        prepend-icon="lock" 
                        label="密码" 
                        type="password" 
                        v-model="password"
                        :rules="passwordRules"
                        ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-card-text>
                    <router-link id="underline" to="/password/reset">忘记登录密码？</router-link>
                </v-card-text>
                <v-spacer></v-spacer>
                <v-btn @click="clear">清空</v-btn>
                <v-btn color="primary" @click="onSubmitSignin" :disabled="!valid" :loading="loading">登录</v-btn>
            </v-card-actions>
            </v-card>
        </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        valid: true,
        loading: false,
        email: '',
        emailRules: [
        v => !!v || '邮箱是必须填写的',
        v => /.+@.+/.test(v) || '请输入有效邮箱地址'
        ],
        password: '',
        passwordRules: [
        v => !!v || '密码是必须填写的',
        v => (v && v.length >= 6) || '密码必须大于8位数'
        ],
        
    }),
    methods: {
        onSubmitSignin () {
            this.loading = true;
            if (this.$refs.form.validate()) {
                this.$http.post('/api/login', {
                    email: this.email,
                    password: this.password,
                })
                .then(({ data }) => {
                this.$store.dispatch('login', data);
                this.$router.push(window.storage.pull('url.intended') || '/');
            })
            .catch((error) => console.log(error.response));
            }
        },  
        clear () {
        this.$refs.form.reset();
        this.loading = false;
        }
    }
    
}
</script>
<style>
#underline {
    text-decoration: none;
}
</style>


