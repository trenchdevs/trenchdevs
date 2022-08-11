import {Link, usePage} from "@inertiajs/inertia-react";
import InertiaTable from "@/Themes/TrenchDevsAdmin/Components/Tables/InertiaTable";
import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import * as Icon from "react-feather";
import Card from "@/Themes/TrenchDevsAdmin/Components/Card";

export default function ProjectsList() {

    const {data} = usePage().props;

    return (
        <TrenchDevsAdminLayout>
            <Card header={"Projects"}>
                <InertiaTable links={data.links} rows={data.data} columns={[
                    {key: 'image_url', 'label': 'Image'},
                    {key: 'id', 'label': 'ID'},
                    {key: 'title', 'label': 'Title'},
                    {key: 'url', 'label': 'URL'},
                    {key: 'repository_url', 'label': 'Repository'},
                    {key: 'created_at', 'label': 'Created At'},
                ]}/>
            </Card>
        </TrenchDevsAdminLayout>
    )
}
