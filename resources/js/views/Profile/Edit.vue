<template>
    <v-container fluid grid-list-xl>
        <v-layout row wrap>
    <v-flex xs12>
    <v-card>
    <v-card-text>
        <v-layout row justify-space-between wrap>
        <v-avatar v-if="imageUrl" size="64" color="primary" tile>
            <v-img :src="imageUrl" />
        </v-avatar>
        <v-avatar v-else size="64" tile>
            <v-img src="/images/avatar.svg"/>
        </v-avatar>
            <v-btn @click="pickImage">上传头像</v-btn>  
        </v-layout>
    </v-card-text>
    </v-card>
    </v-flex>
        <v-flex xs12 sm8 md6>
        <v-card>
        <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation>
            <input
                type="file"
                style="display: none"
                ref="profileImage"
                accept="image/*"
                @change="onImageChange"
                />   
            <v-text-field 
                prepend-icon="person" 
                label="姓" 
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
                prepend-icon="school" 
                label="所在地" 
                type="text" 
                v-model="location"
                :rules="nameRules"
                ></v-text-field>
        </v-form>
        </v-card-text>
        <v-card-actions>
                <v-btn color="primary" @click="onSubmitProfile" :disabled="!valid" block>提交</v-btn>
        </v-card-actions>
        </v-card>
        </v-flex>
        </v-layout>
        </v-container>
</template>

<script>

export default {
    data () {
        return {
            valid: true,
            imageName: '',
            imageUrl: '',
            imageFile: '',
            lastname: '',
            firstname: '',
            location: '',
            nameRules: [
            v => !!v || 'Name is required',
            v => (v && v.length <= 10) || 'Name must be less than 10 characters'
            ],
        }
    },
    methods: {
        pickImage () {
            this.$refs.profileImage.click()
        },
        onImageChange (e) {
            const files = e.target.files;
            if (files[0] !== undefined) {
                this.imageName = files[0].name
                if (this.imageName.lastIndexOf('.') <= 0) {
                    return
                }
                const fr = new FileReader();
                fr.readAsDataURL(files[0]);
                fr.onload = e => {
                    this.imageUrl = fr.result;
                    this.imageFile = files[0];
                }
            } else {
                this.imageName = '';
                this.imageUrl = '';
                this.imageFile = '';
            }
        },
        onSubmitProfile () {
            let formData = new FormData();
            formData.append("avatar", this.imageFile);
            formData.append("lastname", this.lastname);
            formData.append("firstname", this.firstname);
            formData.append("location", this.location);
            formData.append('_method', 'PUT')
            this.$http.post('/api/profile', formData)
                .then(({ data }) => {
                    const user = Object.assign({}, this.$_auth.user, data.user);
                    this.$store.commit('setUser', user);
                    this.$router.push('/');
                })
                .catch((error) => console.log(error.response));
        
        }
    }
}
</script>

<style>

</style>
