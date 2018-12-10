<template>
    <div>
        <v-btn
        v-if="$_auth.check"
        fab
        bottom
        right
        color="primary"
        dark
        fixed
        @click="dialog = !dialog"
        >
        <v-icon>edit</v-icon>
        </v-btn>
        <v-dialog v-model="dialog" fullscreen hide-overlay>
        <v-card >
            <v-card-title >
            <span class="lighten-4 title">创建帖子</span>
            </v-card-title>
            <v-card-text>
                <v-textarea 
                    auto-grow
                    solo
                    flat
                    rows="1"
                    v-model="textInput"
                    placeholder="分享一些新鲜事吧">
                </v-textarea>
                
                <input
                    type="file"
                    style="display: none"
                    ref="image"
                    accept="image/*"
                    @change="onImageChange"
                />    
            </v-card-text>
            <v-img v-if="imageUrl" :src="imageUrl"></v-img> 
            <v-bottom-nav
                :active.sync="bottomNav"
                :value="true"
                absolute
            >
            <v-btn flat @click="pickImage">
                <v-icon medium>camera_alt</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="dialog = false">取消</v-btn>
            <v-btn flat @click="onSubmitStatus">发布</v-btn>
            </v-bottom-nav>
        </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    data: () => ({
        dialog: false,
        bottomNav: 'recent',
        textInput: '',
        imageName: '',
        imageUrl: '',
        imageFile: '',
    }),
    props: {
        parentId: {
            type: Number,
            default: 0
        },
    },
    computed: {
        endpoint () {
            return '/api/statuses' + (this.parentId > 0 ? `/${this.parentId}/replies` : '');
        },
        type () {
            return (this.parentId > 0 ? 'reply' : 'status');
        }
    },
    methods: {
        pickImage () {
            this.$refs.image.click()
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
        onSubmitStatus () {
            let formData = new FormData();
            formData.append("image", this.imageFile);
            formData.append("body", this.textInput);
            this.$http.post(this.endpoint, formData)
                .then(({ data }) => {
                    this.$emit(`${this.type}-posted`, data[this.type]);
                    this.imageUrl = '';
                    this.textInput= '',
                    this.dialog = false
                })
                .catch((error) => console.log(error.response));
        
        }
    }

}
</script>

<style>

</style>
