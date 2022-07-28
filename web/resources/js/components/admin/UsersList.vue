<!-- Example implementation for single page -->
<template>
    <div class="card mb-4">
        <div class="card-header">
            Users
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-sm">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Is Active</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.role }}</td>
                    <td>{{ user.first_name }} {{ user.last_name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ !!user.is_active ? "Yes" : "No" }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>
                        <a href="" class="btn btn-sm btn-primary">
                            <eye-icon/>
                        </a>
                        <a href="" class="btn btn-sm btn-warning">
                            <edit-icon/>
                        </a>
                        <a href="" class="btn btn-sm btn-danger">
                            <trash-icon/>
                        </a>
                    </td>
                </tr>
                </tbody>

            </table>
        </div>

    </div>
</template>

<script>
import {EyeIcon, TrashIcon, EditIcon} from 'vue-feather-icons'

export default {


    components: {
        EyeIcon,
        TrashIcon,
        EditIcon
    },
    data() {
        return {
            users: null
        }
    },
    mounted() {

        axios.get('/api/admin/users/')
            .then(({data}) => {
                this.users = data;
            })
    }
}
</script>
