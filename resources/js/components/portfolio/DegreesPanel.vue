<template>
    <div class="card mb-4">
        <div class="card-header">
            Degrees
        </div>



        <div class="card-body">

            <div class="alert alert-success p-2 pb-0" v-if="infoMessage && infoMessage.length > 0">
                {{ infoMessage }}
            </div>

            <div class="mb-3"></div>

            <div class="mb-3 row" v-for="(degree,index) in degrees">

                <div class="col-md-12">
                    <h4>Degree #{{ index + 1 }}</h4>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Educational Institution</label>
                        <input type="text" class="form-control" v-model="degree.educational_institution">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Degree</label>
                        <input type="text" class="form-control" v-model="degree.degree">
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

            <div class="mt-5" v-if="degrees.length > 0">
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
import {PORTFOLIO_SAVE_DEGREES, PORTFOLIO_GET_DEGREES} from "../../config/Endpoints";

export default {
    components: {
        PlusIcon,
        SaveIcon,
        VueEditor
    },
    async mounted() {
        await this.getDegrees();
    },
    data() {
        return {
            degrees: [],
            errors: [],
            errorMessage: undefined,
            infoMessage: undefined,
        };
    },
    methods: {

        async getDegrees() {

            try {
                const response = await axios.get(PORTFOLIO_GET_DEGREES);
                const {degrees} = response.data;

                if (!_.isEmpty(degrees)) {
                    this.degrees = degrees;
                }

            } catch (error) {
                this.addEntry();
            }
        },

        addEntry() {

            this.degrees.push({
                'educational_institution': '',
                'degree': '',
                'start_date': undefined,
                'end_date': undefined,
                'description': '',
            });
        },

        async save() {

            try {

                const data = {
                    degrees: this.degrees
                };

                const response = await axios.post(PORTFOLIO_SAVE_DEGREES, data);
                const {status, message, errors = []} = response.data;

                if (status === 'success') {
                    this.infoMessage = message;
                    await this.getDegrees();

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
