<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <!-- Authorized Tokens -->
        <div class="table" v-if="tokens.length > 0">
            <div class="tr">
                <div class="th">
                    geautoriseerde applicaties
                </div>
            </div>
            <div class="tr">
                <div class="td">
                    Naam
                </div>
                <div class="td">
                    Scopes
                </div>
            </div>
            <div class="tr" v-for="token in tokens">
                <div class="td">
                    {{ token.client.name }}
                </div>
                <div class="td">
                                <span v-if="token.scopes.length > 0">
                                        {{ token.scopes.join(', ') }}
                                </span>
                </div>
                <div class="td">
                    <a class="action-link text-danger" @click="revoke(token)">
                        Revoke
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                tokens: []
            };
        },

        /**
         * Prepare the component (Vue 1.x).
         */
        ready() {
            this.prepareComponent();
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        methods: {
            /**
             * Prepare the component (Vue 2.x).
             */
            prepareComponent() {
                this.getTokens();
            },

            /**
             * Get all of the authorized tokens for the user.
             */
            getTokens() {
                axios.get('/oauth/tokens')
                    .then(response => {
                        this.tokens = response.data;
                    });
            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                axios.delete('/oauth/tokens/' + token.id)
                    .then(response => {
                        this.getTokens();
                    });
            }
        }
    }
</script>
