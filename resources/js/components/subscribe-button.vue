<template>
    <button @click.prevent="toggleSubscription" class="btn btn-danger">
        {{owner ? '' : subscribed ? 'Unsubscribe' : 'Subscribe'}} {{ count }} {{owner ? 'Subscribers' : '' }}
    </button>
</template>

<script>
import numeral from 'numeral';

export default {

    props: {

        initial_subscriptions: {
            type: Array,
            required: true,
            default: () => []
        },

        channel: {
            type: Object,
            required: true,
            default: () => []
        }
    },

    data() {
        return {
            subscriptions: this.initial_subscriptions
        }
    },
    
    computed: {

        subscribed() {

            return __auth() && this.subscription; 
        },

        subscription() {

            return this.subscriptions.find(subscription => subscription.user_id === __auth().id); 
        },

        owner() {

            return __auth() && this.channel.user_id === __auth().id;
        },

        count() {
            return numeral(this.subscriptions.length).format('0a');
        }
    },
    methods: {
        toggleSubscription() {

            if (!__auth()) {
                return  alert('Please Login To Subsribe');
            }

            if (this.owner) {
                return  alert('You Can\'t Subsribe To Your Channel');
            }

            this.subscribed ?
            axios.delete(`/channels/${this.channel.id}/subscriptions/${this.subscription.id}`)
            .then(() => {
                this.subscriptions = this.subscriptions.filter(s => s.id != this.subscription.id)
            }):

            axios.post(`/channels/${this.channel.id}/subscriptions`)
            .then((response) => {
                this.subscriptions = [
                ...this.subscriptions,
                response.data
                ]
            });

        }
    }
}
</script>

<style>

</style>
    

// this.subscriptions = this.subscriptions.splice(this.subscriptions.indexOf(this.subscription), 1);
// this.subscriptions = this.subscriptions.push(response.data);
