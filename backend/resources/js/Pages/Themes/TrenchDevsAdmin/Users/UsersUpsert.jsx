import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import {Link, useForm} from "@inertiajs/inertia-react";
import {Inertia} from "@inertiajs/inertia";
import * as Icon from 'react-feather'

export default function UsersUpsert(props) {

    const {
        user = {},
        errors = {},
    } = props;

    const form = useForm({
        first_name: '',
        last_name: '',
        email: '',
        is_active: '0',
        password: '',
        role: '',
        ...user
    });

    function submitForm(e) {
        e.preventDefault();
        form.post('/dashboard/users');
    }

    return (
        <TrenchDevsAdminLayout>
            <div className="card mb-4">

                <div className="card-header">
                    Create User
                </div>

                <div className="card-body">

                    <form onSubmit={submitForm}>
                        <div className="row">
                            <div className="form-group col-6">
                                <label htmlFor="first-name">First Name</label>
                                <input
                                    className="form-control"
                                    id="first-name"
                                    name="first_name" type="text"
                                    value={form.data.first_name}
                                    onChange={e => form.setData(e.target.name, e.target.value)}
                                />
                                {errors.first_name && <div className="text-danger">{errors.first_name}</div>}
                            </div>

                            <div className="form-group col-6">
                                <label htmlFor="last-name">Last Name</label>
                                <input
                                    className="form-control"
                                    id="last-name"
                                    name="last_name"
                                    type="text"
                                    value={form.data.last_name}
                                    onChange={e => form.setData(e.target.name, e.target.value)}
                                />
                                {errors.last_name && <div className="text-danger">{errors.last_name}</div>}

                            </div>

                            <div className="form-group col-6">
                                <label htmlFor="email">Email</label>
                                <input
                                    readOnly={form.data.id}
                                    className="form-control"
                                    id="email"
                                    name="email" type="email"
                                    value={form.data.email}
                                    onChange={e => form.setData(e.target.name, e.target.value)}
                                />
                                {errors.email && <div className="text-danger">{errors.email}</div>}
                            </div>


                            <div className="form-group col-6">
                                <label htmlFor="is-active">Is Active</label>
                                <select className="form-control" id="is-active" name="is_active"
                                        onChange={e => form.setData(e.target.name, e.target.value)}
                                >
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                                {errors.is_active && <div className="text-danger">{errors.is_active}</div>}
                            </div>

                            <div className="form-group col-6">
                                <label htmlFor="password">Password</label>
                                <input
                                    className="form-control"
                                    id="password"
                                    name="password"
                                    type="password"
                                    onChange={e => form.setData(e.target.name, e.target.value)}
                                    value={form.data.password}
                                />
                                {errors.password && <div className="text-danger">{errors.password}</div>}
                            </div>

                            <div className="col-6"></div>

                            <div className="form-group col-6">
                                <label htmlFor="role">
                                    Role <br/><small>admin, contributor, business_owner, customer</small>
                                </label>
                                <input
                                    className="form-control"
                                    id="role"
                                    name="role"
                                    type="text"
                                    onChange={e => form.setData(e.target.name, e.target.value)}
                                    value={form.data.role}
                                />
                                {errors.role && <div className="text-danger">{errors.role}</div>}

                            </div>

                            <div className="col-12 text-right">
                                <Link className="btn btn-warning mr-2" href="/dashboard/users">
                                    <Icon.SkipBack size={14}/>
                                    <span className="ml-2">Cancel</span>
                                </Link>
                                <button className="btn btn-success">
                                    <Icon.Save size={14}/>
                                    <span className="ml-2">Save</span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </TrenchDevsAdminLayout>
    );
}
