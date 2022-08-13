import BasicFileUploader from "@/Themes/TrenchDevsAdmin/Components/Files/BasicFileUploader";
import TrenchDevsAdminLayout from "@/Themes/TrenchDevsAdmin/Layouts/TrenchDevsAdminLayout";
import * as Icon from 'react-feather';
import InertiaTable from "@/Themes/TrenchDevsAdmin/Components/Tables/InertiaTable";
import {useForm, usePage} from "@inertiajs/inertia-react";
import Card from "@/Themes/TrenchDevsAdmin/Components/Card";
import {Inertia} from "@inertiajs/inertia";
import {useEffect} from "react";

export default function PhotosList() {

    const {data} = usePage().props;
    const photosForm = useForm({image: null});

    const onUpload = async (acceptedFiles) => {
        await photosForm.setData('image', acceptedFiles[0] || '');
    };

    useEffect(() => {

        if (photosForm.data.image) {
            photosForm.post('/dashboard/photos/upload', {
                preserveScroll: (page) => Object.keys(page.props.errors).length,
            });
            photosForm.reset();
        }

    },[photosForm.data])

    const onDelete = async (id) => {
        if (confirm('Are you sure you want to delete this photo?')) {
            Inertia.post(`/dashboard/photos/delete/${id}`, {
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
                        {photosForm.hasErrors ? <div className="text-danger text-center">{photosForm.errors.image}</div> : ''}
                    </div>
                </div>

                <div className="row">
                    <div className="col">
                        <InertiaTable links={data.links} rows={data.data} columns={[
                            {
                                key: '',
                                'label': 'Image',
                                render: row => <img className="img-fluid"
                                                    style={{maxHeight: "50px"}}
                                                    src={row.s3_url}
                                                    alt={row.identifier}
                                />
                            },
                            {key: 'original_name', 'label': 'Original Name'},
                            {key: 'identifier', 'label': 'Identifier'},
                            {key: 's3_url', 'label': 'S3 URL'},
                            {
                                key: '', style: {width: "10%"},'label': 'Actions', render: row => (
                                    <>
                                        <button className="mr-1 btn btn-xs btn-info" onClick={() =>
                                            navigator.clipboard.writeText(row.s3_url || '')
                                        }>
                                            <Icon.Copy size={14}/>
                                        </button>
                                        <button className="btn btn-xs btn-danger" onClick={() => onDelete(row.id)}>
                                            <Icon.Trash size={14}/>
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
