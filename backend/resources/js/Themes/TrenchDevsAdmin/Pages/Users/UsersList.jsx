import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import {Link, usePage} from "@inertiajs/inertia-react";
import * as Icon from "react-feather";
import {Inertia} from "@inertiajs/inertia";
import InertiaTable from "@/Themes/TrenchDevsAdmin/Components/Tables/InertiaTable";

export default function UsersList(props) {

    const {auth} = usePage().props;

    const {
        data: {data, links},
    } = props;

    function sendResetPasswordEmail(id, email) {

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
                <div className="card-body">

                    <div className="row pb-3">
                        <div className="col text-right">
                            <Link href="/dashboard/users/upsert" className="btn btn-sm btn-success">
                                <Icon.Plus color="white" size={16}/>
                                <span className="ml-1">Add Participant</span>
                            </Link>
                        </div>
                    </div>

                    <InertiaTable
                        links={links}
                        rows={data}
                        columns={[
                            {key: 'id', 'label': 'ID'},
                            {key: 'email', 'label': 'Email'},
                            {key: 'is_active', 'label': 'Is Active?', render: row => row.is_active ? 'Yes' : 'No'},
                            {
                                key: 'actions', 'label': 'Actions', render: row => {
                                    return (
                                        <>
                                            <Link href={`/dashboard/users/upsert/${row.id}`}
                                                  className="btn btn-warning"><Icon.Edit size={12}/>
                                            </Link>
                                            {['superadmin', 'admin'].includes(auth.user.role) &&
                                                <button
                                                    onClick={() => sendResetPasswordEmail(row.id, row.email)}
                                                    className="btn btn-info ml-2"
                                                >
                                                    <Icon.Key size={12}/>
                                                </button>
                                            }
                                        </>
                                    );
                                }
                            },
                        ]}
                    />

                </div>
            </div>
        </TrenchDevsAdminLayout>
    );
}
