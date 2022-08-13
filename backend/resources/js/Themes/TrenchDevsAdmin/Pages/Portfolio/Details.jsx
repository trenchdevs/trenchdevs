import TrenchDevsAdminLayout from "@/Themes/TrenchDevsAdmin/Layouts/TrenchDevsAdminLayout";
import PortfolioStepper from "@/Themes/TrenchDevsAdmin/Components/Portfolio/PortfolioStepper";
import {useForm, usePage} from "@inertiajs/inertia-react";
import React, {useCallback} from 'react'
import Card from "@/Themes/TrenchDevsAdmin/Components/Card";
import DynamicForm from "@/Themes/TrenchDevsAdmin/Components/Forms/DynamicForm";
import BasicFileUploader from "@/Themes/TrenchDevsAdmin/Components/Files/BasicFileUploader";
import * as Icon from 'react-feather';
import {Inertia} from "@inertiajs/inertia";

export default function Details(props) {

    const page = usePage();
    const {details = {}, auth = {}} = page.props;
    const form = useForm({
        ...details || {},
    });


    function submitForm() {
        form.post('/dashboard/portfolio/details', {
            preserveScroll: (page) => Object.keys(page.props.errors).length,
        });
    }

    async function onAvatarUploaded(acceptedFiles) {
        Inertia.post('/dashboard/portfolio/avatar', {avatar: acceptedFiles[0] || null})
    }



    return (
        <TrenchDevsAdminLayout>
            <PortfolioStepper activeStep={1}/>

            <div className="row">
                <div className="col">
                    <Card header="Basic Details">
                        <div className="row">
                            <div className="col-md-3">
                                <BasicFileUploader onUpload={onAvatarUploaded}>
                                    <div className="relative mb-3 mx-auto" style={{width: "250px !important"}}>
                                        <img
                                            style={{height: "250px", width: "250px"}}
                                            className="img-fluid img-thumbnail rounded-circle d-block mx-auto cursor-pointer"
                                            src={auth.user.avatar_url || 'https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png'}
                                            alt="User Avatar URL"
                                        />
                                        <Icon.UploadCloud style={{position: 'absolute', bottom: 0, right: "34%"}}/>
                                    </div>
                                </BasicFileUploader>
                            </div>
                            <div className="col-md-9">
                                <DynamicForm
                                    inertiaForm={form}
                                    entryVerbiage={"Experience"}
                                    formElements={page.props.dynamic_form_elements}
                                    onSubmit={submitForm}
                                />
                            </div>
                        </div>
                    </Card>
                </div>
            </div>

        </TrenchDevsAdminLayout>
    )
}
