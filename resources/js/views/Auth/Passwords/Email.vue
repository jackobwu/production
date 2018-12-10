<template>
    <v-container fluid fill-height>
        <v-layout row wrap>
            <v-flex xs12>
                <v-alert
                    :value="alert"
                    type="success"
                    >
                        邮件发送成功
                </v-alert>
            </v-flex>
            <v-flex xs12 sm8 md4 lg4>
                <v-card class="elevation-1 pa-3">
                <v-card-text>
                    <div class="layout column align-center">
                    <!-- <img src="#" alt="Vue Material Admin" width="120" height="120"> -->
                    <h1 class="flex my-4">发送重置密码邮件</h1>
                    </div>                
                    <v-form ref="form" v-model="valid" lazy-validation>
            
                        <v-text-field 
                            prepend-icon="email" 
                            label="邮箱" 
                            type="email" 
                            v-model="email"
                            :rules="emailRules"
                            ></v-text-field>

                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="onSubmitSendLink" :disabled="!valid" :loading="loading">发送</v-btn>
                </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
    data: () => ({
        alert: false,
        valid: true,
        loading: false,
        email: '',
        emailRules: [
        v => !!v || '邮件不能为空',
        v => /.+@.+/.test(v) || '请填写有效完整的电子邮件地址'
        ]
    }),
    methods: {
        onSubmitSendLink () {
            this.loading = true;
            if (this.$refs.form.validate()) {
                this.$http.post('/api/password/email', {
                    email: this.email,
                })
            .then((response) => this.clear())
            .catch((error) => console.log(error.response))
            }
        },
        clear () {
        this.$refs.form.reset();
        this.loading = false;
        this.alert = true;
        setTimeout(() => {
            this.alert = false;
        }, 3000);
        }
    }
}
</script>

