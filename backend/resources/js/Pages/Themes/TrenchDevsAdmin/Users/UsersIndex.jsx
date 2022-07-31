import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import {Link} from "@inertiajs/inertia-react";
import {Fragment} from "react";
import {Inertia} from "@inertiajs/inertia";

export default function UsersIndex({data: {data, links}}) {

    // function upsertUser(){
    // Inertia.post()
    // }
    console.log(data)
    return (
        <TrenchDevsAdminLayout>
            <div className="bg-white p-5">
                <h2 className="mb-5 border-bottom pb-3">Users</h2>
                <table className="table table-bordered">
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
                                <td></td>
                            </tr>
                        );
                    })}
                    </tbody>
                </table>

                {/* todo: chris - make a component out of this */}
                {
                    links.map(({url, label}) =>
                        url ?
                            <Link className="mx-3" href={url}><span dangerouslySetInnerHTML={{__html: label}}/></Link> :
                            <span dangerouslySetInnerHTML={{__html: label}}/>
                    )
                }
            </div>
        </TrenchDevsAdminLayout>
    );
}
