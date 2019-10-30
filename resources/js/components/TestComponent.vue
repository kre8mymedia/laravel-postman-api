<template>
    <div class="container">
        <h2>Test Component</h2>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tickets: [],
                ticket: {
                    id: '',
                    title: '',
                    body: ''
                },
                ticket_id: '',
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchTickets();
        },

        methods: {
            fetchTickets() {
                fetch('/api/tickets')
                .then(res => res.json())
                .then(res => {
                    console.log(res.data);
                })
            }
        },

        mounted() {
            console.log('Test Component mounted.')
        }
    }
</script>
