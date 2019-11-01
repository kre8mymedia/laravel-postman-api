<template>
    <div class="container">
        <h2>ROLE Component</h2> 
        <form @submit.prevent="addRole" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Role User ID" v-model="role.user_id">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Role Name" v-model="role.name">
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
                    <a @click="fetchRoles(pagination.prev_page_url)" class="page-link">Previous</a>
                </li>

                <li class="page-item disabled"><a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
                    <a @click="fetchRoles(pagination.next_page_url)" class="page-link">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="role in roles" v-bind:key="role.id">
            <h3>{{ role.name }}</h3>
            <p>{{ role.user_id }}</p>
            <hr>
            <button @click="editRole(role)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deleteRole(role.id)" class="btn btn-danger">Delete</button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                roles: [],
                role: {
                    id: '',
                    name: '',
					user_id: '',
                },
                role_id: '',
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchRoles();
        },

        methods: {
            fetchRoles(page_url) {
                let vm = this;
                page_url = page_url || 'api/roles';
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // console.log(res.data);
                    this.roles = res.data;
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

            deleteRole(id) {
                if (confirm('Are you sure?')) {
                    fetch(`api/role/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Role Removed')
                        this.fetchRoles();
                    })
                    .catch(err => console.log(err));
                }
            },

            addRole() {
                if(this.edit === false) {
                    // Add
                    fetch('api/role', {
                        method: 'post',
                        body: JSON.stringify(this.role),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.role.name = '';
						this.role.user_id = '';
                        alert('Role Added');
                        this.fetchRoles();
                    })
                    .catch(err =>console.log(err));
                } else {
                    // Update
                    fetch('api/role', {
                        method: 'put',
                        body: JSON.stringify(this.role),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.role.name = '';
						this.role.user_id = '';
                        alert('Role Updated');
                        this.fetchRoles();
                    })
                    .catch(err =>console.log(err));
                }
            },

            editRole(role) {
                this.edit = true;
                this.role.id = role.id;
                this.role.role_id = role.id;
                this.role.name = role.name;
                this.role.used_id = role.user_id;
            }
        },

        mounted() {
            console.log('Role Component mounted.')
        }
    }
</script>
