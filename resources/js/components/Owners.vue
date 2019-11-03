<template>
   	<div class="container">
     	<h2>OWNER Component</h2>

		<!-- COMPONENT FORM -->
		<div class="form-group">
			<label for="exampleFormControlSelect1">Select Role ID</label>
			<select class="form-control" id="exampleFormControlSelect1">
				<option>1</option>
				<option>2</option>
			</select>
		</div>
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
                role_id: '',
                pagination: {},
                edit: false,
			}
		},

		created() {
			this.fetchOwners();
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

			makePagination(meta, links) {
				let pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					next_page_url: links.next,
					prev_page_url: links.prev
				};
				
				this.pagination = pagination;
            }
		},

        mounted() {
            console.log('Owner Component mounted.')
        }
    }
</script>