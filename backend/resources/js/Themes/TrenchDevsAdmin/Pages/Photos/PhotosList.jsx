import BasicFileUploader from "@/Themes/TrenchDevsAdmin/Components/Files/BasicFileUploader";
import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import * as Icon from 'react-feather';
import InertiaTable from "@/Themes/TrenchDevsAdmin/Components/Tables/InertiaTable";
import {useForm, usePage} from "@inertiajs/inertia-react";
import Card from "@/Themes/TrenchDevsAdmin/Components/Card";

export default function PhotosList() {

    const {data} = usePage().props;
    const photosForm = useForm({image: null});

    const onUpload = async (acceptedFiles) => {
        await photosForm.setData('image', acceptedFiles[0] || '');
        console.log(photosForm.data)
        photosForm.post('/dashboard/photos/upload', {
            preserveScroll: (page) => Object.keys(page.props.errors).length,
        });
    };

    const onDelete = async (id) => {
        if (confirm('Are you sure you want to delete this photo?')) {
            photosForm.post(`/dashboard/photos/delete/${id}`, {
                preserveScroll: (page) => Object.keys(page.props.errors).length,
            })
        }
    }

    return (
        <TrenchDevsAdminLayout>

            <Card header={"All Photos"}>
                <div className="row mb-5">
                    <div className="col">
                        <BasicFileUploader onUpload={onUpload}/>
                        {photosForm.hasErrors ? <div className="text-danger">{photosForm.errors.image}</div> : ''}
                    </div>
                </div>

                <div className="row">
                    <div className="col">
                        <InertiaTable links={data.links} rows={data.data} columns={[
                            {
                                key: '',
                                'label': 'Image',
                                render: row => <img className="img-fluid" style={{maxHeight: "50px"}} src={row.s3_url}
                                                    alt={row.identifier}/>
                            },
                            {key: 'identifier', 'label': 'Identifier'},
                            {key: 's3_url', 'label': 'S3 URL'},
                            {
                                key: '', 'label': 'Actions', render: row => (
                                    <>
                                        <button className="mr-2 btn btn-sm btn-info" onClick={() =>
                                            navigator.clipboard.writeText(row.s3_url || '')
                                        }>
                                            <Icon.Copy/>
                                        </button>
                                        <button className="btn btn-sm btn-danger" onClick={() => onDelete(row.id)}>
                                            <Icon.Trash/>
                                        </button>
                                    </>
                                )
                            }
                        ]}/>
                    </div>
                </div>
            </Card>

        </TrenchDevsAdminLayout>
    );
}
