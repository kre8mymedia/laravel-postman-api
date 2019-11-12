<template>
    <div class="container">
        <h2>PROPERTIES Component</h2>

        <!-- FORM -->
        <form @submit.prevent="addProperty" class="mb-3" enctype="multipart/form-data">

            <!-- OWNER ID --> 
            <div class="form-group">
                <select v-model="property.owner_id" class="form-control" id="exampleFormControlSelect2">
                    <option disabled value="">Select a Owner</option>
                    <option v-for="owner in owners" :key="owner.id" :value="owner.id" >
                        {{owner.name}}
                    </option>
                </select>
            </div>
            <!-- END OWNER ID -->

            <!-- Manager ID --> 
            <div class="form-group">
                <select v-model="property.manager_id" class="form-control" id="exampleFormControlSelect2">
                    <option disabled value="">Select a Manager</option>
                    <option v-for="manager in managers" :key="manager.id" :value="manager.id" >
                        {{manager.name}}
                    </option>
                </select>
            </div>
            <!-- END Manager ID -->

            <div class="form-group">
                <input type="text" class="form-control" name="address" placeholder="Address" v-model="property.address">
            </div>
            <!-- <div class="input-group mb-3">
                <input type="file" name="image" @change="onFileSelected">
            </div> -->
            <button type="submit" class="btn btn-success btn-block">Save</button>
        </form>
        <!-- END FORM -->

        <!-- PAGINATION -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{ disabled: !pagination.prev_page_url }]" class="page-item">
                    <a @click="fetchProperties(pagination.prev_page_url)" class="page-link" href="#">Previous</a>
                </li>

                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>

                <li v-bind:class="[{ disabled: !pagination.next_page_url }]" class="page-item">
                    <a @click="fetchProperties(pagination.next_page_url)" class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
        <!-- END PAGINATION -->

        <!-- LIST OF ITEMS -->
        <div class="card card-body mb-2" v-for="property in properties" v-bind:key="property.id">
            <h3><a target="_blank" v-bind:href="`https://google.com/search?q=` + property.address">{{ property.address }}</a></h3>
            <p>Property Owner: {{ property.owner_user }}</p>
            <p>Property Manager: {{ property.manager_user }}</p>
            <!-- <div class="col-md-3" v-if="image">
                <img :src="image" class="img-responsive" height="70" width="90">
            </div> -->

            <hr>
            <button @click="editProperty(property)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deleteProperty(property.id)" class="btn btn-danger">Delete</button>
        </div>
        <!-- END LIST OF ITEMS -->

    </div>
</template>

<script>
    import axios from 'axios';

    import Tenants from './Tenants.vue';

    export default {
        data() {
            return {
                properties: [],
                property: {
                    id: '',
                    owner_id: '',
                    manager_id: '',
                    address: '',
                    image: ''
                },
                owners: [],
                owner: {
                    "id": '',
                    "role_id": '',
                    "user_id": '',
                    "name": "",
                    "email": ""
                },
                managers: [],
                manager: {
                    "id": '',
                    "role_id": '',
                    "user_id": '',
                    "name": "",
                    "email": ""
                },
                selectedFile: null,
                property_id: '',
                pagination: {},
                edit: false
            }
        },

        components: {
            Tenants
        },

        created() {
            this.fetchProperties();
            this.fetchOwners();
            this.fetchManagers();
        },

        methods: {
            fetchProperties(page_url) {
                let vm = this;
                page_url = page_url || 'api/properties'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // console.log(res.data);
                    this.properties = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },

            fetchOwners(page_url) {
                let vm = this;
                page_url = page_url || 'api/owners'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // Users log to console
                    console.log(res.data);
                    // this fetches user data
                    this.owners = res.data;
                    // Get this vue's structure pagination?
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
            },

            fetchManagers(page_url) {
                let vm = this;
                page_url = page_url || 'api/managers'
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    // Users log to console
                    console.log(res.data);
                    // this fetches user data
                    this.managers = res.data;
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

            deleteProperty(id) {
                if (confirm('Are you sure?')) {
                    fetch(`api/property/${id}`, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Property Removed')
                        this.fetchProperties();
                    })
                    .catch(err => console.log(err));
                }
            },

            addProperty() {
                // If edit prop is equal to false ADD PROPERTY else.. UPDATE
                if(this.edit === false) {
                    fetch('api/property', {
                        method: 'post',
                        body:JSON.stringify(this.property),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.property.owner_id = '';
                        this.property.manager_id = '';
                        this.property.address = '';
                        this.property.image = '';
                        alert('Property Added');
                        this.fetchProperties();
                    })
                    .catch(err =>console.log(err));
                } else {
                    // Update
                    fetch('api/property', {
                        method: 'put',
                        body: JSON.stringify(this.property),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
					.then(data => {
                        this.property.owner_id = '';
                        this.property.manager_id = '';
                        this.property.address = '';
                        this.property.image = '';
                        alert('Property Updated');
                        this.fetchProperties();
                    })
                    .catch(err =>console.log(err));
                }
            },

            editProperty(property) {
                this.edit = true;
                this.property.id = property.id;
                this.property.property_id = property.id;
                this.property.owner_id = property.owner_id;
				this.property.manager_id = property.manager_id;
                this.property.address = property.address;
                this.property.image = property.image;
            }
        },

        mounted() {
            console.log('Properties Component mounted.')
        }
    }
</script>
