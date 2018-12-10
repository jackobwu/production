<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4 lg4>
            <v-card class="elevation-1 pa-3">
            <v-card-text>
                <div class="layout column align-center">
                <!-- <img src="#" alt="Vue Material Admin" width="120" height="120"> -->
                <h1 class="flex my-4">注 册</h1>
                </div>                
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-text-field 
                        prepend-icon="person" 
                        label="贵姓" 
                        type="text" 
                        v-model="lastname"
                        :rules="nameRules"
                        ></v-text-field>
                    <v-text-field 
                        prepend-icon="person" 
                        label="名字" 
                        type="text" 
                        v-model="firstname"
                        :rules="nameRules"
                        ></v-text-field>
                    <v-text-field 
                        prepend-icon="email" 
                        label="邮箱" 
                        type="email" 
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
                    <v-text-field 
                        prepend-icon="lock" 
                        label="再次确认密码" 
                        type="password" 
                        v-model="password_confirmation"
                        :rules="passwordRules"
                        ></v-text-field>
                    </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="clear">清空</v-btn>
                <v-btn color="primary" @click="onSubmitSignup" :disabled="!valid" :loading="loading">注册</v-btn>
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
        lastname: '',
        firstname: '',
        token: '',
        nameRules: [
        v => !!v || '姓名不能为空',
        v => (v && v.length <= 10) || '请填写真实姓名'
        ],
        email: '',
        emailRules: [
        v => !!v || '邮箱不能为空',
        v => /.+@.+/.test(v) || '请填写完整有效邮箱地址'
        ],
        password: '',
        password_confirmation: '',
        passwordRules: [
        v => !!v || '密码不能为空',
        v => (v && v.length >= 6) || '密码必须大于8位数'
        ],
    }),
    methods: {
        onSubmitSignup () {
            this.loading = true;
            this.token = this.$route.params.token;
            if (this.$refs.form.validate()) {
                this.$http.post('/api/register', {
                    lastname: this.lastname,
                    firstname: this.firstname,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    token: this.token
                })
                .then(({ data }) => {
                this.$store.dispatch('login', data);
                this.$router.push('/');
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

</style>
