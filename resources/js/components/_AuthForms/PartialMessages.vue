<template>
    <div>
        <div v-if="errors && errors.length" class="alert alert-danger alert-notification">
            <ul class="list-unstyled mb-0">
                <li v-for="err in errors">{{ err }}</li>
            </ul>
        </div>

        <div v-for="msg in session_success" class="alert alert-success alert-notification">
            <i class="fa fa-check"></i>
            {{ msg }}
        </div>
    </div>
</template>

<script>
    export default {
        name: 'PartialMessages',
        props: {
            errors: Array,
            session_success: {}
        },
    }
</script>