<template>
    <div class="card mb-4">
        <div class="card-header">
            Certifications
        </div>


        <div class="card-body">

            <div class="alert alert-success p-2 pb-0" v-if="infoMessage && infoMessage.length > 0">
                {{ infoMessage }}
            </div>

            <div class="mb-3"></div>

            <div class="mb-3 row" v-for="(certification,index) in certifications">

                <div class="col-md-12">
                    <h4>Certification #{{ index + 1 }}</h4>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="certification.title">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Issuer</label>
                        <input type="text" class="form-control" v-model="certification.issuer">
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Certification URL</label>
                        <input type="text" class="form-control" v-model="certification.certification_url">
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Expiration Date</label>
                        <input type="date" class="form-control" v-model="certification.expiration_date">
                    </div>
                </div>

            </div>


            <div class="mb-3">
                <button class="btn btn-info"
                        @click="addEntry">
                    <plus-icon/>
                    <span class="pl-1">Add</span>
                </button>
            </div>


            <div class="alert alert-danger p-2 pb-0" v-if="errorMessage && errors.length > 0">
                <ul class="list-unstyled mb-0">
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>

            <div class="mt-5" v-if="certifications.length > 0">
                <button class="btn btn-success" @click="save">
                    <save-icon/>
                    <span class="pl-1">Save</span>
                </button>
            </div>


        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    import _ from 'lodash';
    import {VueEditor} from "vue2-editor";
    import {PlusIcon, SaveIcon} from 'vue-feather-icons'
    import {PORTFOLIO_CERTIFICATIONS_GET, PORTFOLIO_CERTIFICATIONS_SAVE} from "../../config/Endpoints";

    export default {
        components: {
            PlusIcon,
            SaveIcon,
            VueEditor
        },
        async mounted() {
            await this.getCertifications();
        },
        data() {
            return {
                certifications: [],
                errors: [],
                errorMessage: undefined,
                infoMessage: undefined,
            };
        },
        methods: {

            async getCertifications() {

                try {
                    const response = await axios.get(PORTFOLIO_CERTIFICATIONS_GET);
                    const {certifications} = response.data;

                    if (!_.isEmpty(certifications)) {
                        this.certifications = certifications;
                    }

                } catch (error) {
                    this.addEntry();
                }
            },

            addEntry() {

                this.certifications.push({
                    'title': '',
                    'issuer': '',
                    'certification_url': '',
                    'expiration_date': undefined,
                });
            },

            async save() {

                try {

                    console.log('data', this.certifications);

                    const data = {
                        certifications: this.certifications
                    };

                    const response = await axios.post(PORTFOLIO_CERTIFICATIONS_SAVE, data);
                    const {status, message, errors = []} = response.data;

                    if (status === 'success') {
                        this.infoMessage = message;
                        await this.getCertifications();

                        window.scrollTo({
                            behavior: 'smooth',
                            top: 0,
                        });

                        this.errors = [];
                        this.errorMessage = undefined;

                    } else {
                        this.errors = errors;
                        this.errorMessage = message;
                    }

                } catch (e) {

                }

            }
        }
    }

</script>
