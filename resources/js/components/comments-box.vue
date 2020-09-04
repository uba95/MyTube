<template>
    <div class="card mt-5 p-5">
        <div v-if="auth" class="form-inline my-4 w-full">
            <input v-model="newComment" type="text" class="form-control form-control-sm w-80">
            <button @click="addComment" class="btn btn-sm btn-primary">
                <small>Add comment</small>
            </button>
        </div>

        <comment v-for="comment in comments.data" :key="comment.id" :comment="comment" :video="video"/>

        <div class="text-center mt-3">

            <button v-if="comments.next_page_url" @click="fetchComments" class="btn btn-light">
                See More Comments
            </button>
            <strong v-else class="text-muted">No More Comments To Show</strong>
        </div>
    </div>

</template>

<script>
import Comment from "./comment.vue"

export default {
    props: ['video'],
    components: {
        Comment,
    },
    data: () => ({
        comments: {
            data: []
        },
        newComment: ''
    }),
    computed: {
        auth() {
            return __auth()
        }
    },
    mounted() {
        this.fetchComments()
    },
    methods: {
        fetchComments() {

            const url = this.comments.next_page_url ?? `/videos/${this.video.id}/comments`
            axios.get(url)
            .then(({data}) => {
                this.comments = {
                    ...data, // paginate + data
                    data: [
                        ...this.comments.data, // old comments
                        ...data.data, // new comments
                    ]
                }
            })
        },
        addComment() {
            if (!this.newComment) return

            axios.post(`/videos/${this.video.id}/comments`, {body: this.newComment, video_id: this.video.id})
            .then(({data}) => {
                this.comments = {
                    ...this.comments,
                    data: [
                        data,
                        ...this.comments.data
                    ]
                }
                this.newComment = ''
            })
        }
    }
}
</script>

<style>

</style>