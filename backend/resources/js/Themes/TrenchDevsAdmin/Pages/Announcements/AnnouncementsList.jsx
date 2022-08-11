import {Link, usePage} from "@inertiajs/inertia-react";
import InertiaTable from "@/Themes/TrenchDevsAdmin/Components/Tables/InertiaTable";
import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import * as Icon from "react-feather";
import Card from "@/Themes/TrenchDevsAdmin/Components/Card";

export default function AnnouncementsList() {

    const {data} = usePage().props;

    return (
        <TrenchDevsAdminLayout>
            <Card header={"Announcements"}>
                <div className="row pb-3">
                    <div className="col text-right">
                        <Link href="/dashboard/announcements/create" className="btn btn-sm btn-success">
                            <Icon.Mic color="white" size={14}/>
                            <span className="ml-1">Create</span>
                        </Link>
                    </div>
                </div>

                <InertiaTable links={data.links} rows={data.data} columns={[
                    {key: 'id', 'label': 'ID'},
                    {key: 'title', 'label': 'Title'},
                    {key: 'status', 'label': 'Status'},
                    {key: 'create_notifications', 'label': 'Create Notifications'},
                    {key: 'send_emails', 'label': 'Send Emails'},
                    {key: 'error_message', 'label': 'System Message'},
                    {key: 'created_at', 'label': 'Created At'},
                ]}/>
            </Card>
        </TrenchDevsAdminLayout>
    )
}
