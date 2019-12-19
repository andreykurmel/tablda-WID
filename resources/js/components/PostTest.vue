<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <button class="btn btn-warning" @click="testAx()">Test Axios</button>
                        <button class="btn btn-warning" @click="testWeb()">Test Jquery</button>
                    </div>

                    <div class="card-body">
                        <div v-show="api_id !== -1">User id from axios: {{ api_id }}</div>
                        <div v-show="web_id !== -1">User id from jquery: {{ web_id }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PostTest",
        data() {
            return {
                web_id: -1,
                api_id: -1,
            }
        },
        methods: {
            testAx() {
                axios.post('/laravel/web-post-user').then((request) => {
                    this.api_id = request.data;
                });
            },
            testWeb() {
                $.post({
                    url: '/laravel/web-post-user',
                    success: (data) => {
                        this.web_id = data;
                    }
                });
            },
        },
        mounted() {
        }
    }
</script>

<style scoped="">
    .container {
        margin-top: 30px;
    }
</style>