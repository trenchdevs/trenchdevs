<template>
    <div class="card mb-4">
        <div class="card-header">
            Projects
        </div>


        <div class="card-body">

            <div class="alert alert-success p-2 pb-0" v-if="infoMessage && infoMessage.length > 0">
                {{ infoMessage }}
            </div>

            <div class="mb-3"></div>

            <div class="mb-3 row" v-for="(project,index) in projects">

                <div class="col-md-12">
                    <h4>Project #{{ index + 1 }}</h4>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" v-model="project.title">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>URL</label>
                        <input type="text" class="form-control" v-model="project.url">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Repository URL</label>
                        <input type="text" class="form-control" v-model="project.repository_url">
                    </div>
                </div>

<!--                <div class="col-md-6">-->
<!--                    <div class="form-group">-->
<!--                        <label>Users</label>-->
<!--                        <input type="text" class="form-control" v-model="project.users">-->
<!--                    </div>-->
<!--                </div>-->

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

            <div class="mt-5" v-if="projects.length > 0">
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
    import {PORTFOLIO_PROJECTS_GET, PORTFOLIO_PROJECTS_SAVE} from "../../config/Endpoints";

    export default {
        components: {
            PlusIcon,
            SaveIcon,
            VueEditor
        },
        async mounted() {
            await this.getProjects();
        },
        data() {
            return {
                projects: [],
                errors: [],
                errorMessage: undefined,
                infoMessage: undefined,
            };
        },
        methods: {

            async getProjects() {

                try {
                    const response = await axios.get(PORTFOLIO_PROJECTS_GET);
                    const {projects} = response.data;

                    if (!_.isEmpty(projects)) {
                        this.projects = projects;
                    }

                } catch (error) {
                    this.addEntry();
                }
            },

            addEntry() {

                this.projects.push({
                    'title': '',
                    'is_personal': true,
                    'url': '',
                    'repository_url': '',
                    'users': [],
                });
            },

            async save() {

                try {

                    console.log('data', this.projects);

                    const data = {
                        projects: this.projects
                    };

                    const response = await axios.post(PORTFOLIO_PROJECTS_SAVE, data);
                    const {status, message, errors = []} = response.data;

                    if (status === 'success') {
                        this.infoMessage = message;
                        await this.getProjects();

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
