import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import {Link} from "@inertiajs/inertia-react";
import * as Icon from "react-feather";

export default function UsersIndex(props) {

    console.log(props);
    const {
        data: {data, links},
    } = props;

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
                            <table className="table table-striped table-responsive">
                                <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>Actions</td>
                                </tr>
                                </thead>
                                <tbody>
                                {data.map(({id, email, name}) => {
                                    return (
                                        <tr key={id}>
                                            <td>{id}</td>
                                            <td>{name}</td>
                                            <td>{email}</td>
                                            <td>
                                                <Link href={`/dashboard/users/upsert/${id}`}
                                                      className="btn btn-warning"><Icon.Edit size={12}/></Link>
                                            </td>
                                        </tr>
                                    );
                                })}
                                </tbody>
                            </table>

                            {/* todo: chris - make a component out of this */}
                            <nav aria-label="Page navigation example">
                                <ul className="pagination">
                                    {
                                        links.map(({url, label, active}) =>
                                            (
                                                <li key={label}
                                                    className={`page-item ${active && 'active'} ${!url && 'disabled'}`}>
                                                    <Link className={`page-link`} href={url}>
                                                        <span dangerouslySetInnerHTML={{__html: label}}/></Link>

                                                </li>
                                            )
                                        )}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </TrenchDevsAdminLayout>
    );
}
