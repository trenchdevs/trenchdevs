import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import PortfolioStepper from "@/Themes/TrenchDevsAdmin/Components/Portfolio/PortfolioStepper";
import {useForm, usePage} from "@inertiajs/inertia-react";
import DynamicListForm from "@/Themes/TrenchDevsAdmin/Components/Forms/DynamicListForm";

export default function Certifications(props) {

    const page = usePage();
    const form = useForm([
        ...page.props.certifications || []
    ]);

    function submitForm() {
        form.post('/dashboard/portfolio/certifications', {
            preserveScroll: (page) => Object.keys(page.props.errors).length,
        });
    }

    return (
        <TrenchDevsAdminLayout>
            <PortfolioStepper activeStep={2}/>

            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-header">
                            Certifications
                        </div>
                        <div className="card-body">
                            <DynamicListForm
                                inertiaForm={form}
                                entryVerbiage={"Certification"}
                                formElements={page.props.dynamic_form_elements}
                                onSubmit={submitForm}
                            />
                        </div>
                    </div>
                </div>
            </div>

        </TrenchDevsAdminLayout>
    )
}
