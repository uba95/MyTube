<template>
    <div class="media my-2 border p-2">
        <avatar :username="comment.user.name" class='mr-3' :size="40"></avatar>
        <div class="media-body">
            <h6 class="mt-0 font-weight-bold">{{ comment.user.name }}</h6>
            <small>{{ comment.body }}</small>
            <div class="d-flex">
                <vote-buttons :default_votes ='comment.votes' :entity_id ='comment.id' :entity_owner ='comment.user_id' entity_type="comment" />
                <button class="btn btn-sm btn-link m-2" @click="ReplyInput = ! ReplyInput">
                    <small>
                    {{ ReplyInput ? 'Cancel' : 'Reply' }}
                    </small>
                </button>
            </div>
            <div v-if="ReplyInput" class="form-inline my-4 w-full">
                <input v-model="newReply" type="text" class="form-control form-control-sm w-80">
                <button @click="addReply" class="btn btn-sm btn-link">
                    <small>Add Reply</small>
                </button>
            </div>

            <replies ref="replies" :comment="comment" />
        </div>
    </div>
</template>
<script>
import Replies from "./replies.vue"
import Avatar from "vue-avatar"

export default {
    props: {
        comment: {
            required: true,
            default: () => ({})
        },
        video: {
            required: true,
            default: () => ({})
        }
    },
    components: {
        Avatar,
        Replies,
    },
    data() {
        return {
            ReplyInput: false,
            newReply: '',
        }
    },
    methods: {
        addReply() {
            if (!this.newReply) return

            axios.post(`/videos/${this.video.id}/comments`, {
                body: this.newReply,
                video_id: this.video.id,
                comment_id: this.comment.id
            })
            .then(({data}) => {
                this.$refs.replies.addReply(data)
                this.newReply = ''
                this.ReplyInput = false
            })
        }
    },
}
</script>