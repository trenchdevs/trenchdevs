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

                Note: By default this creates an activity feed and emails all participants in TrenchDevs account.

                <div class="row">
                    <div class="col text-right">
                        <button class="btn btn-success" v-on:click="announce">Announce</button>
                    </div>
                </div>
            </div>

           <div class="alert alert-danger" v-if="errors">
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

            };
        },
        methods: {
            announce() {
                const data = {
                    title: this.title,
                    message: this.message,
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
