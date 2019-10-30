<template>
    <div class="container">
        <h2>Test Component</h2>
        <form @submit.prevent="addTicket" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="ticket.title">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Body" v-model="ticket.body">
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
                    <a @click="fetchTickets(pagination.prev_page_url)" class="page-link" href="#">Previous</a>
                </li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
                    <a @click="fetchTickets(pagination.next_page_url)" class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body" v-for="ticket in tickets" v-bind:key="ticket.id">
            <h3>{{ ticket.title }}</h3>
            <p>{{ ticket.body }}</p>
            <hr>
            <button @click="deleteTicket(ticket.id)" class="btn btn-danger">Delete</button>
        </div>
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
            fetchTickets(page_url) {
                let vm = this;
                page_url = page_url || 'api/tickets'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // console.log(res.data);
                    this.tickets = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },

            makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };

            this.pagination = pagination;
            },

            deleteTicket(id) {
                if (confirm('Are you sure?')) {
                    fetch(`api/ticket/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Ticket Removed')
                        this.fetchTickets();
                    })
                    .catch(err => console.log(err));
                }
            },

            addTicket() {
                if(this.edit === false) {
                    // Add
                    fetch('api/ticket', {
                        method: 'post',
                        body: JSON.stringify(this.ticket),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.ticket.title = '';
                        this.ticket.body = '';
                        alert('Ticket Added');
                        this.fetchTickets();
                    })
                    .catch(err =>console.log(err));
                } else {
                    
                }
            },

            editTicket(ticket) {
                this.edit = true;
                this.ticket = ticket.id;
                this.ticket.ticket_id = ticket.id;
                this.ticket.ticket
            }
        },

        mounted() {
            console.log('Test Component mounted.')
        }
    }
</script>
