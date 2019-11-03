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
            <button @click="editOwner(role)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deleteOwner(owner.id)" class="btn btn-danger">Delete</button>
        </div>
        <!-- END CARDS -->
   </div>
</template>

<script>
    export default {
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

        mounted() {
            console.log('Owner Component mounted.')
        }
    }
</script>