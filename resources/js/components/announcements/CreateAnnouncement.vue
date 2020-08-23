<template>
    <div class="card mb-4">
        <div class="card-header">
            Create Announcement
        </div>
        <div class="card-body">
            <div>
                <div class="form-group">
                    <label for="title">Title / Subject</label>
                    <input
                        v-model="title"
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter Title"
                    >
                </div>
                <div class="form-group">
                    <vue-editor v-model="message"/>
                </div>

                <div class="form-group">
                    <label for="emails">Email Addresses (CSV) </label>
                    <textarea class="form-control" name="emails" id="emails" v-model="emails"/>
                </div>

                <div class="alert alert-info">
                    Note: If no emails are specified, by default this creates an activity feed and emails all
                    participants in the TrenchDevs account.
                </div>

                <div class="row">
                    <div class="col text-right">
                        <button class="btn btn-success" v-on:click="announce">Announce</button>
                    </div>
                </div>
            </div>

            <div class="alert alert-danger m-3" v-if="errors">
                <ul>
                    <li v-for="error in errors">{{error[0]}}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";
    import axios from 'axios';

    export default {
        components: {
            VueEditor,
        },
        mounted() {
            console.log('component mounted...')
        },
        data() {
            return {
                title: '',
                message: "Enter email contents here..",
                errors: null,
                emails: null,
            };
        },
        methods: {
            announce() {
                const data = {
                    title: this.title,
                    message: this.message,
                    emails: this.emails || null,
                };
                axios.post('/announcements/announce', data)
                    .then((d) => {
                        window.location.href = "/announcements"
                    })
                    .catch(({response}) => {
                        const {errors} = response.data;
                        if (errors) {
                            this.errors = errors;
                        }
                    });
            }
        }
    }
</script>
