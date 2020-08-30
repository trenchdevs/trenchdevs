<template>
    <div class="card mb-4">
        <div class="card-header">
            Experiences
        </div>


        <div class="card-body">

            <div class="alert alert-success p-2 pb-0" v-if="infoMessage && infoMessage.length > 0">
                {{ infoMessage }}
            </div>

            <div class="mb-3"></div>

            <div class="mb-3 row" v-for="(degree,index) in experiences">

                <div class="col-md-12">
                    <h4>Experience #{{ index + 1 }}</h4>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="degree.title">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Company</label>
                        <input type="text" class="form-control" v-model="degree.company">
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" class="form-control" v-model="degree.start_date">
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" class="form-control" v-model="degree.end_date">
                    </div>
                </div>

                <div class="col-md-12">

                    <div class="form-group">
                        <label>Description</label>
                        <vue-editor v-model="degree.description"/>
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

            <div class="mt-5" v-if="experiences.length > 0">
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
    import {PORTFOLIO_EXPERIENCES_GET, PORTFOLIO_EXPERIENCES_SAVE} from "../../config/Endpoints";

    export default {
        components: {
            PlusIcon,
            SaveIcon,
            VueEditor
        },
        async mounted() {
            await this.getExperiences();
        },
        data() {
            return {
                experiences: [],
                errors: [],
                errorMessage: undefined,
                infoMessage: undefined,
            };
        },
        methods: {

            async getExperiences() {

                try {
                    const response = await axios.get(PORTFOLIO_EXPERIENCES_GET);
                    const {experiences} = response.data;

                    if (!_.isEmpty(experiences)) {
                        this.experiences = experiences;
                    }

                } catch (error) {
                    this.addEntry();
                }
            },

            addEntry() {

                this.experiences.push({
                    'title': '',
                    'company': '',
                    'start_date': undefined,
                    'end_date': undefined,
                    'description': '',
                });
            },

            async save() {

                try {

                    console.log('data', this.experiences);

                    const data = {
                        experiences: this.experiences
                    };

                    const response = await axios.post(PORTFOLIO_EXPERIENCES_SAVE, data);
                    const {status, message, errors = []} = response.data;

                    if (status === 'success') {
                        this.infoMessage = message;
                        await this.getExperiences();

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
