import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import PortfolioStepper from "@/Themes/TrenchDevsAdmin/Components/Portfolio/PortfolioStepper";
import {useForm, usePage} from "@inertiajs/inertia-react";
import Card from "@/Themes/TrenchDevsAdmin/Components/Card";
import DynamicForm from "@/Themes/TrenchDevsAdmin/Components/Forms/DynamicForm";

export default function Skills(props) {

    const page = usePage();
    const {skills = {}, auth = {}} = page.props;
    const form = useForm({
        ...skills || {},
    });

    function submitForm() {
        form.post('/dashboard/portfolio/skills', {
            preserveScroll: (page) => Object.keys(page.props.errors).length,
        });
    }

    return (
        <TrenchDevsAdminLayout>
            <PortfolioStepper activeStep={3}/>
            <div className="row">
                <div className="col">
                    <Card header="Skills">
                        <DynamicForm
                            inertiaForm={form}
                            // entryVerbiage={"Skill"}
                            formElements={page.props.dynamic_form_elements}
                            onSubmit={submitForm}
                        />
                    </Card>
                </div>
            </div>

        </TrenchDevsAdminLayout>
    )
}
