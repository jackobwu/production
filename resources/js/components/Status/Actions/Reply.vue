<template>
    <div class="reply">
        <v-dialog
            v-model="reply"
            hide-overlay
        >
            <v-btn icon
                slot="activator"
            >
                <v-icon small>chat_bubble_outline</v-icon>
                <small>{{ status.replies_count }}</small>
            </v-btn>
            <v-card >
            <v-card-title >
            <span class="lighten-4 title">创建回复</span>
            </v-card-title>
            <v-card-text>
                <v-textarea 
                    auto-grow
                    solo
                    flat
                    rows="3"
                    v-model="textInput"
                    placeholder="回复帖子。。。">
                </v-textarea>
                
                <input
                    type="file"
                    style="display: none"
                    ref="image"
                    accept="image/*"
                    @change="onImageChange"
                />    
            </v-card-text>
            <!-- <v-img v-if="imageUrl" :src="imageUrl"></v-img>  -->
            <v-bottom-nav
                :active.sync="bottomNav"
                :value="true"
                absolute
            >
            <!-- <v-btn flat @click="pickImage">
                <v-icon medium>camera_alt</v-icon>
            </v-btn> -->
            <v-spacer></v-spacer>
            <v-btn flat color="primary" @click="reply = false">取消</v-btn>
            <v-btn flat @click="onSubmitStatus">回复</v-btn>
            </v-bottom-nav>
        </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    data () {
        return {
            reply: false,
            bottomNav: 'recent',
            textInput: '',
            imageName: '',
            imageUrl: '',
            imageFile: '',
        }
    },
    props: {
        status: {
            type: Object,
            required: true
        },
        parentId: {
            type: Number,
            default: 0
        }
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
            let formData = new FormData;
            formData.append("image", this.imageFile);
            formData.append("body", this.textInput);
            this.$http.post(this.endpoint, formData)
                .then(({ data }) => {
                    //this.$emit(`${this.type}-posted`, data[this.type]);
                    this.status.replies_count++;
                    //this.imageUrl = '';
                    this.textInput= '',
                    this.reply = false
                })
                .catch((error) => console.log(error.response));
        
        }
    }
}
</script>

<style>

</style>
