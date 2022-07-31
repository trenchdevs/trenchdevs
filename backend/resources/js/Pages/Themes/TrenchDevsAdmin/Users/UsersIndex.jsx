import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import {Link, usePage} from "@inertiajs/inertia-react";
import * as Icon from "react-feather";
import Paginator from "@/Components/Themes/TrenchDevsAdmin/Paginator";
import {Inertia} from "@inertiajs/inertia";

export default function UsersIndex(props) {

    const {auth} = usePage().props;

    const {
        data: {data, links},
    } = props;

    function sendResetPasswordEmail(id, email){

        if (confirm(`Are you sure you want to send a password confirmation link to this email ${email}?`)) {
            Inertia.post(`/dashboard/users/password-reset`, {id});
        }
    }

    return (
        <TrenchDevsAdminLayout>
            <div className="card mb-4">
                <div className="card-header">
                    Users
                </div>
                <div className="card-body table-responsive">

                    <div className="row pb-3">
                        <div className="col text-right">
                            <Link href="/dashboard/users/upsert" className="btn btn-sm btn-success">
                                <Icon.Plus color="white" size={16}/>
                                <span className="ml-1">Add Participant</span>
                            </Link>
                        </div>
                    </div>

                    <div className="row">
                        <div className="col">
                            <table className="table table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Is Active?</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                {data.map(({id, email, name, is_active}) => {
                                    return (
                                        <tr key={id}>
                                            <td>{id}</td>
                                            <td>{name}</td>
                                            <td>{email}</td>
                                            <td>{is_active ? 'Yes' : 'No'}</td>
                                            <td>
                                                <Link href={`/dashboard/users/upsert/${id}`}
                                                      className="btn btn-warning"><Icon.Edit size={12}/>
                                                </Link>
                                                {['superadmin', 'admin'].includes(auth.user.role) &&
                                                    <button
                                                        onClick={() => sendResetPasswordEmail(id, email)}
                                                        // href={'/dashboard/users/password-reset'}
                                                        // method={"POST"}
                                                        className="btn btn-info ml-2"
                                                        // data={{id}}
                                                    >
                                                        <Icon.Key size={12}/>
                                                    </button>
                                                }
                                            </td>
                                        </tr>
                                    );
                                })}
                                </tbody>
                            </table>

                            <Paginator links={links}/>
                        </div>
                    </div>
                </div>
            </div>
        </TrenchDevsAdminLayout>
    );
}
