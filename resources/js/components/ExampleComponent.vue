<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header">{{ message.owner }}</div>
                    <Owner />
                </div>
                
                <div class="card mb-3">
                    <div class="card-header">{{ message.manager }}</div>
                    <Manager />
                </div>

                <div class="card mb-3">
                    <div class="card-header">{{ message.tenant }}</div>
                    <Tenant />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Owner from './Owners.vue'
    import Manager from './Managers.vue'
    import Tenant from './Tenants.vue'

    export default {
        data() {
            return {
                message: {
                    owner: "Owner Component",
                    manager: "Manager Component",
                    tenant: "Tenant Component"
                }
            }
        },
       
        mounted() {
            console.log('Example Component mounted.')
        }
    }
</script>
