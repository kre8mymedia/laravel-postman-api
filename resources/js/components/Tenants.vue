<template>
   	<div class="container">

		<!-- PAGINATION -->
        <nav class="mt-3" aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
                    <a @click="fetchTenants(pagination.prev_page_url)" class="page-link">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
                    <a @click="fetchTenants(pagination.next_page_url)" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
        <!-- END PAGINATION -->

        <!-- MANAGERS TABLE -->
        <table class="table table-hover">
            <thead>
                <tr class='text-center'>
                    <th scope="col">ID</th><th scope="col">Role ID</th><th>Property ID</th><th scope="col">Name</th><th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tenant in tenants" v-bind:key="tenant.id" class='text-center'>
                    <th scope="row">{{ tenant.id }}</th><td>{{ tenant.role_id }}</td><td>24</td><td>{{ tenant.name }}</td><td>{{ tenant.email }}</td>
                </tr>
            </tbody>
        </table>
        <!-- END MANAGERS TABLE -->
   </div>
</template>

<script>
    export default {
		// Data object to be return with component after render
		data() {
			return {
				tenants:[],
				tenant: {
					id: '',
					role_id: '',
				},
				tenant_id: '',
				pagination: {},
				edit: false,
			}
		},

		created() {
			this.fetchTenants();
		},

		methods: {
			fetchTenants(page_url) {
				let vm = this;
                page_url = page_url || 'api/tenants'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // Tenants log to console
                    console.log(res.data);
                    // this fetches tenants data
                    this.tenants = res.data;
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
			
			deleteTenant(id) {
				if (confirm('Are you sure?')) {
					fetch(`api/tenant/${id}`, {
						method: 'delete'
					})
					.then(res => res.json())
					.then(data => {
						alert('Tenant Removed')
						this.fetchTenants();
					})
					.catch(err => console.log(err));
				}
			},

            addTenant() {
                if(this.edit === false) {
                    // Add
                    fetch('api/tenant', {
                        method: 'post',
                        body: JSON.stringify(this.tenant),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.tenant.role_id = '';
                        alert('Tenant Added');
                        this.fetchTenants();
                    })
                    .catch(err =>console.log(err));
                } else {
                    // Update
                    fetch('api/tenant', {
                        method: 'put',
                        body: JSON.stringify(this.tenant),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
						this.tenant.role_id = '';
						alert('Tenant Updated');
                        this.fetchTenants();
                    })
                    .catch(err =>console.log(err));
                }
            },

            editTenant(tenant) {
              this.edit = true;
              this.tenant.id = tenant.id;
              this.tenant.tenant_id = tenant.id;
              this.tenant.role_id = tenant.role_id;
            }

		},

        mounted() {
            console.log('TENANT Component mounted.')
        }
    }
</script>