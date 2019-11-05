<template>
    <div class="container">
        <h2>PROPERTIES Component</h2>
        <form @submit.prevent="addProperty" class="mb-3" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Owner ID" v-model="property.owner_id">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Manager ID" v-model="property.manager_id">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Address" v-model="property.address">
            </div>
			<form>
			<div class="form-group">
				<label>EXAMPLE 1 file input</label>
				<input type="file" @change="onFileSelected" name="property_image" class="form-control-file">
                <!-- <button @click="onUpload">Upload</button> -->
			</div>

            <!-- <div class="form-group">
				<label for="exampleFormControlFile1">Example file input</label>
				<input type="file" class="form-control-file" name="property_image" id="property_image">
			</div> -->
			</form>
            
            <button type="submit" class="btn btn-success btn-block">Save</button>
        </form>
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
        <div class="card card-body mb-2" v-for="property in properties" v-bind:key="property.id">
            <h3>{{ property.address }}</h3>
            <p>Owner ID: {{ property.owner_id }}</p>
            <p>Owner User: {{ property.owner_user }}</p>
            <p>Manager ID: {{ property.manager_id }}</p>
            <p>Manager User: {{ property.manager_user }}</p>
            <hr>
            <button @click="editProperty(property)" class="btn btn-warning mb-2">Edit</button>
            <button @click="deleteProperty(property.id)" class="btn btn-danger">Delete</button>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                properties: [],
                property: {
                    id: '',
                    owner_id: '',
                    manager_id: '',
                    address: '',
                    property_image: ''
                },
                selectedFile: null,
                property_id: '',
                pagination: {},
                edit: false
            }
        },

        created() {
            this.fetchProperties();
        },

        methods: {
            onFileSelected(event) {
                this.selectedFile = event.target.files[0]
                console.log(this.selectedFile);
            },

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
                if(this.edit === false) {
                    // Add
                    fetch('api/property', {
                        method: 'post',
                        body: JSON.stringify(this.property),
                        headers: {
                            'content-type': [
                                'multipart/form-data',
                                'application/json'
                            ]
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.property.owner_id = '';
                        this.property.manager_id = '';
                        this.property.address = '';
                        this.property.property_image ='';
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
                        this.property.property_image ='';
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
                this.property.property_image = property.property_image;
            }
        },

        mounted() {
            console.log('Properties Component mounted.')
        }
    }
</script>
