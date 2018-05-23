<template>
    <div>
        <div class="table">
            <div class="tr">
                <div class="th">
                    Persoonlijke toeganglijkheids tokens.
                    <i class="fa fa-plus-circle" @click="showCreateTokenForm"></i>
                </div>
            </div>
            <div class="tr" v-if="tokens.length === 0">
                <div class="td">
                    Je hebt geen persoonlijke Toegankelijkheid ‘s tokens gemaakt.
                </div>
            </div>
                <div class="tr" v-if="tokens.length > 0" v-for="token in tokens">
                    <div class="td label">
                        Name
                    </div>
                    <div class="td">
                        {{ token.name }}
                    </div>
                    <div class="td auto-width">
                        <i class="fa fa-remove" @click="revoke(token)"></i>
                    </div>
                </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="modal-create-token" :class="[tokenModal ? 'is-active' : '']">
            <div class="modal-dialog">
                <div class="table clean">
                    <div class="tr">
                        <div class="th">
                            Maak token
                            <i class="fa fa-close" @click="closeTokenModal"></i>
                        </div>
                    </div>
                    <div class="tr"  v-if="form.errors.length > 0">
                        <div class="td error" v-for="error in form.errors">
                            {{ error }}
                        </div>
                    </div>
                    <form @submit.prevent="store">
                        <div class="tr">
                            <div class="td label big">
                                <label for="create-token-name">Naam</label>
                            </div>
                            <div class="td">
                                <input id="create-token-name" type="text" name="name" v-model="form.name">
                            </div>
                        </div>
                        <div v-if="scopes.length > 0">
                            <div class="tr">
                                <div class="td label big">
                                    Scopes
                                </div>
                                <div class="td" v-for="scope in scopes">
                                    <input type="checkbox"
                                           @click="toggleScope(scope.id)"
                                           :checked="scopeIsAssigned(scope.id)">

                                    {{ scope.id }}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tr">
                    <div class="td">
                        <button type="button" @click="store">
                            Verzenden
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal" :class="[accessTokenModal ? 'is-active' : '']">
            <div class="modal-dialog">
                <div class="table clean">
                    <div class="tr">
                        <div class="th">
                            Persoonlijke toegangelijksheids token.
                            <i class="fa fa-close" @click.prevent="closeAccessTokenModal"></i>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td big auto-height">
                            <p>
                                Here is your new personal access token. This is the only time it will be shown so don't
                                lose it!
                                You may now use this token to make API requests.
                            </p>
                        </div>
                    </div>
                    <div class="tr">
                        <div class="td big auto-height">
                            <textarea rows="20" disabled v-html="accessToken"></textarea>
                        </div>
                    </div>
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
                accessToken: null,

                tokens: [],
                scopes: [],
                form: {
                    name: '',
                    scopes: [],
                    errors: []
                },
                tokenModal: false,
                accessTokenModal: false
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
             * Prepare the component.
             */
            prepareComponent() {
                this.getTokens();
                this.getScopes();
            },

            /**
             * Get all of the personal access tokens for the user.
             */
            getTokens() {
                axios.get('/oauth/personal-access-tokens')
                    .then(response => {
                        this.tokens = response.data;
                    });
            },

            /**
             * Get all of the available scopes.
             */
            getScopes() {
                axios.get('/oauth/scopes')
                    .then(response => {
                        this.scopes = response.data;
                    });
            },

            /**
             * Show the form for creating new tokens.
             */
            showCreateTokenForm() {
                this.tokenModal = true
            },

            /**
             * Create a new personal access token.
             */
            store() {
                this.accessToken = null;
                this.form.errors = [];
                axios.post('/oauth/personal-access-tokens', this.form)
                    .then(response => {
                        this.form.name = '';
                        this.form.scopes = [];
                        this.form.errors = [];
                        this.tokens.push(response.data.token);
                        this.showAccessToken(response.data.accessToken);
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            this.form.errors = _.flatten(_.toArray(error.response.data.errors));
                        } else {
                            this.form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Toggle the given scope in the list of assigned scopes.
             */
            toggleScope(scope) {
                if (this.scopeIsAssigned(scope)) {
                    this.form.scopes = _.reject(this.form.scopes, s => s == scope);
                } else {
                    this.form.scopes.push(scope);
                }
            },

            /**
             * Determine if the given scope has been assigned to the token.
             */
            scopeIsAssigned(scope) {
                return _.indexOf(this.form.scopes, scope) >= 0;
            },

            /**
             * Show the given access token to the user.
             */
            showAccessToken(accessToken) {
                this.closeTokenModal();

                this.accessToken = accessToken;

                this.accessTokenModal = true
            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                axios.delete('/oauth/personal-access-tokens/' + token.id)
                    .then(response => {
                        this.getTokens();
                    });
            },

            closeTokenModal () {
                this.tokenModal = false
            },

            closeAccessTokenModal () {
                this.accessTokenModal = false
            }
        }
    }
</script>
