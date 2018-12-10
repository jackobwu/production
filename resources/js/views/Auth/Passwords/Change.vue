<template>
    <v-container fluid fill-height>
        <v-layout align-center justify-center>
            <v-flex xs12 sm8 md4 lg4>
                <v-card class="elevation-1 pa-3">
                <v-card-text>
                    <div class="layout column align-center">
                    <!-- <img src="#" alt="Vue Material Admin" width="120" height="120"> -->
                    <h1 class="flex my-4 ">修改密码</h1>
                    </div>                
                    <v-form ref="form" v-model="valid" lazy-validation >
                        
                        <v-text-field 
                            prepend-icon="lock" 
                            label="旧密码" 
                            type="password" 
                            v-model="old_password"
                            :rules="passwordRules"
                            ></v-text-field>
                        <v-text-field 
                            prepend-icon="lock" 
                            label="新密码" 
                            type="password" 
                            v-model="password"
                            :rules="passwordRules"
                            ></v-text-field>
                        <v-text-field 
                            prepend-icon="lock" 
                            label="再次确认新密码" 
                            type="password" 
                            v-model="password_confirmation"
                            :rules="passwordRules"
                            ></v-text-field>

                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="onSubmitChangePassword" :disabled="!valid" :loading="loading">修改</v-btn>
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
        old_password: '',
        password: '',
        password_confirmation: '',
        passwordRules: [
        v => !!v || '密码不能为空',
        v => (v && v.length >= 6) || '密码不能低于6位数'
        ],
        
    }),
    methods: {
        onSubmitChangePassword () {
            if (this.$refs.form.validate()) {
                this.$http.post('/api/password/change', {
                        old_password: this.old_password,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    })
                    .then((response) => this.$router.push('/'))
                    .catch((error) => console.log(error.response));
            }
        }
    }
    
}
</script>
