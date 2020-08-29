<template>
    <div class="card mb-4">
        <div class="card-header">
            Skills
        </div>


        <div class="card-body">

            <div class="alert alert-success p-2 pb-0" v-if="infoMessage && infoMessage.length > 0">
                {{ infoMessage }}
            </div>

            <div class="alert alert-info p-2 pb-2">
                Enter your skills based on fluency.
            </div>

            <div class="mb-3"></div>

            <div class="row">
                <div class="col-md-12 mb-5">
                    <h6 class="pb-2 border-bottom mb-3">Tourist</h6>
                    <vue-editor v-model="skills.tourist"/>
                </div>
                <div class="col-md-12 mb-5">
                    <h6 class="pb-2 border-bottom mb-3">Conversationally Fluent</h6>
                    <vue-editor v-model="skills.conversationally_fluent"/>
                </div>
                <div class="col-md-12 mb-5">
                    <h6 class="pb-2 border-bottom mb-3">Fluent</h6>
                    <vue-editor v-model="skills.fluent"/>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <h4>Skills Preview</h4>
                </div>
            </div>

            <hr>

            <div class="row mt-5">
                <div class="col-md-4">
                    <h5 class="mb-3">Fluent</h5>
                    <div v-html="skills.fluent"></div>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Conversationally Fluent</h5>
                    <div v-html="skills.conversationally_fluent"></div>

                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Tourist</h5>
                    <div v-html="skills.tourist"></div>
                </div>
            </div>

            <div class="alert alert-danger p-2 pb-0" v-if="errorMessage && errors.length > 0">
                <ul class="list-unstyled mb-0">
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>


            <div>
                <button class="btn btn-success float-right" @click="save">
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
import {
    PORTFOLIO_SKILLS_GET,
    PORTFOLIO_SKILLS_SAVE
} from "../../config/Endpoints";

export default {
    components: {
        PlusIcon,
        SaveIcon,
        VueEditor
    },
    async mounted() {
        await this.getSkills();
    },
    data() {
        return {
            skills: {
                fluent: undefined,
                conversationally_fluent: undefined,
                tourist: undefined,
            },
            errors: [],
            errorMessage: undefined,
            infoMessage: undefined,
        };
    },
    methods: {

        async getSkills() {

            try {
                const response = await axios.get(PORTFOLIO_SKILLS_GET);
                const {skills} = response.data;

                if (!_.isEmpty(skills)) {
                    this.skills = skills;
                }

            } catch (error) {

            }
        },


        async save() {

            try {

                const response = await axios.post(PORTFOLIO_SKILLS_SAVE, {...this.skills});
                const {status, message, errors = []} = response.data;

                if (status === 'success') {
                    this.infoMessage = message;
                    await this.getSkills();

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
