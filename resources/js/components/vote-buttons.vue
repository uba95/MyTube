<template>
    <div class="d-flex align-items-center">
        <button @click.prevent="vote('up')" class="btn px-3" type="submit">
            <div :class="{'text-primary': upvoted}" :style="{'color':'#666','fontSize': entity_type=='video' ? '19px' : entity_type=='comment' ? '16px' : '15px'}">
                <i class="fas fa-thumbs-up"></i>
                <span>{{ upvotes_count }}</span>
            </div>
        </button>
        <button @click.prevent="vote('down')" class="btn px-3" type="submit">
            <div :class="{'text-primary': downvoted}" :style="{'color':'#666','fontSize': entity_type=='video' ? '19px' : entity_type=='comment' ? '16px' : '15px'}">
                <i class="fas fa-thumbs-down"></i>
                <span>{{ downvotes_count }}</span>
            </div>
        </button>
    </div>
</template>

<script>
import numeral from 'numeral';

export default {

    props: {
        default_votes: {
            required: true,
            default: () => []
        },
        entity_owner: {
            required: true,
            default: ''
        },
        entity_id: {
            required: true,
            default: ''
        },
        entity_type: {
            required: true,
            default: ''
        },
    },

    data() {
        return {
            votes: this.default_votes,
        }
    },

    computed: {
        upvotes() {
            return this.votes.filter(v => v.type == 'up')
        },
        downvotes() {
            return this.votes.filter(v => v.type == 'down')
        },
        upvotes_count() {
            return numeral(this.upvotes.length).format('0a');
        },
        downvotes_count() {
            return numeral(this.downvotes.length).format('0a');
        },
        upvoted() {
            return __auth() && this.upvotes.find(v => v.user_id === __auth().id)
        },
        downvoted() {
            return __auth() && this.downvotes.find(v => v.user_id === __auth().id)
        },
        owner() {
            return this.entity_owner === __auth().id;
        },
        entity_vote() {
            return this.votes.find(v => v.user_id === __auth().id)
        },
    },
    methods: {
        vote(type) {

            if (!__auth()) {
                return  alert('Please Login To Vote');
            }

            if (this.owner) {
                return  alert('You Can\'t Vote This Item');
            }

            if ((type === 'up' && this.upvoted) || (type === 'down' && this.downvoted))  {
                axios.delete(`/votes/${this.entity_vote.id}`)
                .then(() => {
                this.votes = this.votes.filter(v => v.id != this.entity_vote.id)
                })

            }

            axios.post(`/votes/${this.entity_id}/${type}`)
            .then(({data}) => {
                if (this.entity_vote) {
                    this.votes = this.votes.map(v => {
                        return v.user_id === __auth().id ? data : v
                    })
                } else {

                    this.votes = [...this.votes, data]
                }
            })
        }
    }
}
</script>

<style>

</style>
// if (type === 'up' && this.upvoted) return
// if (type === 'down' && this.downvoted) return
