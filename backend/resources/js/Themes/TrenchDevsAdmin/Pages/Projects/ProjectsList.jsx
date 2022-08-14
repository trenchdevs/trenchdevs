import {usePage} from "@inertiajs/inertia-react";
import InertiaTable from "@/Themes/TrenchDevsAdmin/Components/Tables/InertiaTable";
import TrenchDevsAdminLayout from "@/Themes/TrenchDevsAdmin/Layouts/TrenchDevsAdminLayout";
import Card from "@/Themes/TrenchDevsAdmin/Components/Card";

export default function ProjectsList() {

    const {data} = usePage().props;

    return (
        <TrenchDevsAdminLayout>
            <Card header={"Projects"}>
                <InertiaTable links={data.links} rows={data.data} columns={[
                    {key: 'image_url', 'label': 'Image', type: 'image'},
                    {key: 'id', 'label': 'ID'},
                    {key: 'title', 'label': 'Title'},
                    {key: 'url', 'label': 'URL', type: 'external_link'},
                    {key: 'repository_url', 'label': 'Repository'},
                    {key: 'created_at', 'label': 'Created At'},
                ]}/>
            </Card>
        </TrenchDevsAdminLayout>
    )
}
