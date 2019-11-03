<template>
   	<div class="container">
     	<h2>OWNER Component</h2>

		<!-- COMPONENT FORM --> 
        <form @submit.prevent="addOwner" class="mb-3">

			<div class="form-group">
                <input type="text" class="form-control" placeholder="Role ID" v-model="owner.role_id">
            </div>

			<!-- submit --> 
				<button type="submit" class="btn btn-primary btn-block">Save</button>
		</form>
		<!-- END COMPONENT FORM -->

		<!-- PAGINATION -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
                    <a @click="fetchOwners(pagination.prev_page_url)" class="page-link">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
                    <a @click="fetchOwners(pagination.next_page_url)" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
        <!-- END PAGINATION -->

        <!-- CARDS -->
        <div class="card card-body mb-2" v-for="owner in owners" v-bind:key="owner.id">
            <h3>Owner ID: {{ owner.id }}</h3>
            <p>Owner Role ID: {{ owner.role_id }}</p>
			<p>Owner Name: {{ owner.name }}</p>
			<p>Owner Email: {{ owner.email }}</p>
            <hr>
            <button @click="editOwner(owner)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deleteOwner(owner.id)" class="btn btn-danger">Delete</button>
        </div>
        <!-- END CARDS -->
   </div>
</template>

<script>
    export default {
		// Data object to be return with component after render
		data() {
			return {
				owners:[],
				owner: {
					id: '',
					role_id: '',
				},
				roles:[],
                owner_id: '',
                pagination: {},
                edit: false,
			}
		},

		created() {
			this.fetchOwners();
			this.fetchRoles();
		},

		methods: {
			fetchOwners(page_url) {
				let vm = this;
                page_url = page_url || 'api/owners'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // Owners log to console
                    console.log(res.data);
                    // this fetches owners data
                    this.owners = res.data;
                    // Get this vue's structure pagination?
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));	
			},

			fetchRoles(page_url) {
                let vm = this;
                page_url = page_url || 'api/roles'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // Users log to console
                    console.log(res.data);
                    // this fetches user data
                    this.users = res.data;
                    // Get this vue's structure pagination?
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
			
			deleteOwner(id) {
                if (confirm('Are you sure?')) {
                    fetch(`api/owner/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Owner Removed')
                        this.fetchOwners();
                    })
                    .catch(err => console.log(err));
                }
            },

            addOwner() {
                if(this.edit === false) {
                    // Add
                    fetch('api/owner', {
                        method: 'post',
                        body: JSON.stringify(this.owner),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.owner.role_id = '';
                        alert('Owner Added');
                        this.fetchOwners();
                    })
                    .catch(err =>console.log(err));
                } else {
                    // Update
                    fetch('api/owner', {
                        method: 'put',
                        body: JSON.stringify(this.owner),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
						this.owner.role_id = '';
                        alert('Owner Updated');
                        this.fetchOwners();
                    })
                    .catch(err =>console.log(err));
                }
            },

            editOwner(owner) {
				this.edit = true;
				this.owner.id = owner.id;
				this.owner.owner_id = owner.id;
                this.owner.role_id = owner.role_id;
            }

		},

        mounted() {
            console.log('Owner Component mounted.')
        }
    }
</script>