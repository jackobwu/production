<template>
    <div class="content">
        <v-layout v-if="friendship === 'waiting'" row wrap>
            <!-- <v-flex class="text-xs-center" xs12>
                <v-chip color="info" text-color="white" light>等待{{ user.lastname }}{{ user.firstname }}接受你的好友请求。</v-chip>
            </v-flex> -->
            <v-flex class="text-xs-center">
            <v-btn  @click="onClickCancel" xs12>
                <span>取消请求</span>
            </v-btn>
            </v-flex>
        </v-layout>

        <template v-if="friendship === 'pending'">
            <v-btn color="success" @click="onClickAccept">
                <span>接受请求</span>
            </v-btn>
            <v-btn  @click="onClickDecline">
                <span>取消</span>
            </v-btn>
        </template>

        <v-layout v-if="friendship === 'friends'" row wrap>
            <v-flex class="text-xs-center" xs12>
            <v-dialog 
                v-model="dialog"
                width="300">
            <v-btn slot="activator" color="white">
                <span>已经是好友</span>
            </v-btn>
            <v-card>
            <v-card-title class="subheading">你确定要解除和{{ this.user.firstname }}的好友关系?</v-card-title>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" flat @click.native="dialog = false">Disagree</v-btn>
            <v-btn color="red darken-1" flat @click.native="onConfirm">Agree</v-btn>
            </v-card-actions>
        </v-card>
            </v-dialog>
            </v-flex>
        </v-layout>

        <template v-if="friendship === 'not_friends'">
            <v-btn color="primary" @click="onClickAdd">
                <span>添加好友</span>
            </v-btn>
        </template>
    </div>
</template>

<script>
export default {
    data () {
        return {
        dialog: false,
        processing: false
        }
    },
    props: {
        friendship: {
            type: String,
            required: true
        },
        user: {
            type: Object,
            required: true
        }
    },
    methods: {
        onClickAdd () {
            this.request('post', '/api/friendships', { id: this.user.id }, 'waiting');
        },
        onClickAccept () {
            this.request('put', `/api/friendships/${this.user.id}`, {}, 'friends');
        },
        onClickCancel () {
            this.request('delete', `/api/friendships/${this.user.id}`, { params: { action: 'cancel' } }, 'not_friends');
        },
        onClickDecline () {
            this.request('delete', `/api/friendships/${this.user.id}`, { params: { action: 'decline' } }, 'not_friends');
        },
        onConfirm () {
            this.request('delete', `/api/friendships/${this.user.id}`, { params: { action: 'unfriend' } }, 'not_friends');
            this.dialog = false;
        },

        request (requestType, url, data, friendship) {
            this.processing = true;
            this.$http[requestType](url, data)
                .then((response) => {
                    this.processing = false;
                    this.$emit('update:friendship', friendship);
                })
                .catch((error) => {
                    this.processing = false;
                    console.log(error.response);
                });
        }
    }
};
</script>

