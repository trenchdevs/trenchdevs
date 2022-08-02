import {Link, usePage} from "@inertiajs/inertia-react";
import CustomTable from "@/Themes/TrenchDevsAdmin/Components/CustomTable";
import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import * as Icon from "react-feather";

export default function BlogsList() {

    const {data} = usePage().props;

    return (
        <TrenchDevsAdminLayout>
            <div className="card">
                <div className="card-header">
                    Blogs
                </div>
                <div className="card-body">

                    <div className="row pb-3">
                        <div className="col text-right">
                            <Link href="/dashboard/blogs/upsert" className="btn btn-sm btn-success">
                                <Icon.PenTool color="white" size={14}/>
                                <span className="ml-1">Create</span>
                            </Link>
                        </div>
                    </div>

                    <CustomTable links={data.links} rows={data.data} columns={[
                        {
                            key: 'primary_image_url', 'label': 'Image', render: row => {
                                return <img className="img-thumbnail img-fluid" style={{maxHeight: '50px'}}
                                            src={row.primary_image_url} alt={row.title}/>
                            }
                        },
                        {key: 'id', 'label': 'ID'},
                        {key: 'title', 'label': 'Title'},
                        {key: 'slug', 'label': 'Slug'},
                        {key: 'status', 'label': 'Status'},
                        {key: 'publication_date', 'label': 'Publication Date'},
                        {key: 'created_at', 'label': 'Created At'},
                        {
                            key: '', 'label': 'Actions', render: row => (
                                <>
                                    <Link href={`/dashboard/blogs/upsert/${row.id}`}
                                          className="btn btn-warning"><Icon.Edit size={12}/>
                                    </Link>
                                    <Link href={`/dashboard/blogs/preview/${row.id}`}
                                          className="ml-2 btn btn-info"><Icon.Eye size={12}/>
                                    </Link>
                                </>
                            )
                        },
                    ]}/>
                </div>
            </div>
        </TrenchDevsAdminLayout>
    )
}
