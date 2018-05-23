<style scoped>
    .action-link {
        cursor: pointer;
    }
</style>

<template>
    <div>
        <div class="table">
            <div class="tr">
                <div class="th">
                    OAuth Clients
                    <i class="fa fa-plus-circle" @click="showCreateClientForm"></i>
                </div>
            </div>

            <!-- Current Clients -->
            <div class="tr" v-if="clients.length === 0">
                <div class="td">
                    Je hebt nog geen OAuth clienten aangemaakt
                </div>
            </div>


            <div class="tr" v-if="clients.length > 0">
                <div class="td small">
                    Client ID
                </div>
                <div class="td normal">
                    Name
                </div>
                <div class="td">
                    Secret
                </div>
            </div>
            <div class="tr" v-for="client in clients">
                <div class="td small">
                    {{ client.id }}
                </div>
                <div class="td normal">
                    {{ client.name }}
                </div>
                <div class="td">
                    <code>{{ client.secret }}</code>
                </div>
                <div class="td auto-width">
                    <i class="fa fa-edit" @click="edit(client)"></i>
                    <i class="fa fa-remove" @click="destroy(client)"></i>
                </div>
            </div>
        </div>

        <div id="modal-create-client" class="modal" :class="[clientModal ? 'is-active' : '']">
            <div class="modal-dialog">
                <div class="table clean">
                    <div class="tr">
                        <div class="th">
                            Maak client aan
                            <i class="fa fa-close" @click.prevent="closeClientModal"></i>
                        </div>
                    </div>
                    <div class="tr"  v-if="createForm.errors.length > 0">
                        <div class="td error" v-for="error in createForm.errors">
                            {{ error }}
                        </div>
                    </div>
                    <form role="form">
                        <div class="tr">
                            <div class="td label big">
                                <label for="create-client-name">Naam</label>
                            </div>
                            <div class="td">
                                <input id="create-client-name" type="text" class="form-control"
                                       @keyup.enter="store" v-model="createForm.name">
                            </div>
                            <div class="td description">
                                Iets wat de gebruikers zullen herkennen.
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td label big">
                                <label for="redirect">URL</label>
                            </div>
                            <div class="td">
                                <input id="redirect" type="text" class="form-control" name="redirect"
                                       @keyup.enter="store" v-model="createForm.redirect">
                            </div>
                            <div class="td description">
                                De terugroep authorisatie van de url.
                            </div>
                        </div>
                        <div class="tr">
                            <div class="td">
                                <button type="button" @click="store">
                                    Verzenden
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal" id="modal-edit-client" tabindex="-1" role="dialog" :class="[]">
            <div class="modal-dialog">
                <div class="table clean">
                    <div class="tr">
                        <div class="th">
                            Wijzig Client
                            <i class="fa fa-close" @click="closeEditClientModal"></i>
                        </div>
                    </div>
                    <div class="tr" v-if="editForm.errors.length > 0">
                        <div class="td error big" v-for="error in editForm.errors">
                            {{ error }}
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
                clients: [],

                createForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    redirect: ''
                },
                clientModal: false,
                editClientModal: false
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
                this.getClients();
            },

            /**
             * Get all of the OAuth clients for the user.
             */
            getClients() {
                axios.get('/oauth/clients')
                    .then(response => {
                        this.clients = response.data;
                    });
            },

            /**
             * Show the form for creating new clients.
             */
            showCreateClientForm() {
                this.clientModal = true
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/oauth/clients',
                    this.createForm, '#modal-create-client'
                );
            },

            /**
             * Edit the given client.
             */
            edit(client) {
                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.redirect = client.redirect;

                this.closeEditClientModal()
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/oauth/clients/' + this.editForm.id,
                    this.editForm, '#modal-edit-client'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getClients();

                        form.name = '';
                        form.redirect = '';
                        form.errors = [];

                        this.closeClientModal();
                        this.closeEditClientModal()
                    })
                    .catch(response => {
                        if (typeof response.data === 'object') {
                            form.errors = _.flatten(_.toArray(response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(client) {
                axios.delete('/oauth/clients/' + client.id)
                    .then(response => {
                        this.getClients();
                    });
            },

            closeClientModal () {
                this.clientModal = false
            },

            closeEditClientModal () {
                this.editClientModal = false
            }
        }
    }
</script>
