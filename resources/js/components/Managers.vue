<template>
   	<div class="container">
     	<h2>MANAGER Component</h2>

		<!-- PAGINATION -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
                    <a @click="fetchManagers(pagination.prev_page_url)" class="page-link">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
                    <a @click="fetchManagers(pagination.next_page_url)" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
        <!-- END PAGINATION -->

        <!-- CARDS -->
        <div class="card card-body mb-2" v-for="manager in managers" v-bind:key="manager.id">
            <h3>Manager ID: {{ manager.id }}</h3>
            <p>Manager Role ID: {{ manager.role_id }}</p>
            <p>Manager Name: {{ manager.name }}</p>
            <p>Manager Email: {{ manager.email }}</p>
            <hr>
        </div>
        <!-- END CARDS -->
        
   </div>
</template>

<script>
    export default {
		// Data object to be return with component after render
		data() {
			return {
				managers:[],
				manager: {
					id: '',
					role_id: '',
				},
				// roles:[],
        manager_id: '',
        pagination: {},
        edit: false,
			}
		},

		created() {
			this.fetchManagers();
			// this.fetchRoles();
		},

		methods: {
			fetchManagers(page_url) {
				let vm = this;
                page_url = page_url || 'api/managers'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // Managers log to console
                    console.log(res.data);
                    // this fetches managers data
                    this.managers = res.data;
                    // Get this vue's structure pagination?
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));	
			},

			// fetchRoles(page_url) {
      //           let vm = this;
      //           page_url = page_url || 'api/roles'
      //           fetch(page_url)
      //           .then(res => res.json())
      //           .then(res => {
      //               // Users log to console
      //               console.log(res.data);
      //               // this fetches user data
      //               this.users = res.data;
      //               // Get this vue's structure pagination?
      //               vm.makePagination(res.meta, res.links);
      //           })
      //           .catch(err => console.log(err));
      //       },

			makePagination(meta, links) {
				let pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					next_page_url: links.next,
					prev_page_url: links.prev
				};
				
				this.pagination = pagination;
			},
			
			deleteManager(id) {
                if (confirm('Are you sure?')) {
                    fetch(`api/manager/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Manager Removed')
                        this.fetchManagers();
                    })
                    .catch(err => console.log(err));
                }
            },

            addManager() {
                if(this.edit === false) {
                    // Add
                    fetch('api/manager', {
                        method: 'post',
                        body: JSON.stringify(this.manager),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.manager.role_id = '';
                        alert('Manager Added');
                        this.fetchManagers();
                    })
                    .catch(err =>console.log(err));
                } else {
                    // Update
                    fetch('api/manager', {
                        method: 'put',
                        body: JSON.stringify(this.manager),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
						this.manager.role_id = '';
						alert('Manager Updated');
                        this.fetchManagers();
                    })
                    .catch(err =>console.log(err));
                }
            },

            editManager(manager) {
				this.edit = true;
				this.manager.id = manager.id;
				this.manager.manager_id = manager.id;
                this.manager.role_id = manager.role_id;
            }

		},

        mounted() {
            console.log('MANAGER Component mounted.')
        }
    }
</script>