import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import PortfolioStepper from "@/Themes/TrenchDevsAdmin/Components/Portfolio/PortfolioStepper";
import * as Icon from 'react-feather';
import {useForm, usePage} from "@inertiajs/inertia-react";
import FormInput from "@/Themes/TrenchDevsAdmin/Components/FormInput";
import {isArray} from "lodash";

export default function Experiences(props) {

    const page = usePage();
    const form = useForm([
        ...page.props.experiences || []
    ]);

    function submitForm() {
        form.post('/dashboard/portfolio/experiences', {
            preserveScroll: (page) => Object.keys(page.props.errors).length,
        });
    }

    return (
        <TrenchDevsAdminLayout>
            <PortfolioStepper activeStep={1}/>

            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-header">
                            Experiences
                        </div>
                        <div className="card-body">

                            {/*<pre><code>{JSON.stringify(form.data, null, 4)}</code></pre>*/}
                            {
                                isArray(form.data) &&
                                form.data.map((experience, index) => {
                                    return (
                                        <div className="mb-3 row" key={index}>
                                            <div className="col-md-12">
                                                <h4>
                                                    Experience #{index + 1}
                                                    <button
                                                        className="float-right btn mr-2 btn-sm btn-danger"
                                                        onClick={() => {
                                                            const copy = [...form.data];
                                                            copy.splice(index, 1);
                                                            form.setData([...copy]);
                                                        }}
                                                    >
                                                        <Icon.Trash/>
                                                    </button>

                                                    <>
                                                        {
                                                            index !== 0 &&
                                                            <button
                                                                className="float-right mr-2 btn-sm btn btn-info"
                                                                onClick={() => {
                                                                    const copy = [...form.data];
                                                                    const temp = form.data[index - 1]
                                                                    copy[index - 1] = form.data[index];
                                                                    copy[index] = temp;
                                                                    form.setData([...copy]);
                                                                }}
                                                            >
                                                                <Icon.ArrowUp/>
                                                            </button>
                                                        }

                                                        {
                                                            index !== form.data.length - 1 &&
                                                            <button
                                                                className="float-right mr-2 btn-sm btn btn-info"
                                                                onClick={() => {
                                                                    const copy = [...form.data];
                                                                    const temp = form.data[index + 1]
                                                                    copy[index + 1] = form.data[index];
                                                                    copy[index] = temp;
                                                                    form.setData([...copy]);
                                                                }}
                                                            >
                                                                <Icon.ArrowDown/>
                                                            </button>
                                                        }
                                                    </>
                                                </h4>
                                            </div>

                                            <div className="col-md-6">
                                                <div className="form-group">
                                                    <label>Title</label>
                                                    <FormInput
                                                        className='form-control'
                                                        form={form}
                                                        name={`${index}.title`}
                                                        type="text"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-md-6">
                                                <div className="form-group">
                                                    <label>Company</label>
                                                    <FormInput
                                                        className='form-control'
                                                        form={form}
                                                        name={`${index}.company`}
                                                        type="text"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-md-6">

                                                <div className="form-group">
                                                    <label>Start Date</label>
                                                    <FormInput
                                                        className='form-control'
                                                        form={form}
                                                        name={`${index}.start_date`}
                                                        type="date"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-md-6">

                                                <div className="form-group">
                                                    <label>End Date</label>
                                                    <FormInput
                                                        className='form-control'
                                                        form={form}
                                                        name={`${index}.end_date`}
                                                        type="date"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-md-12">

                                                <div className="form-group">
                                                    <label>Description</label>
                                                    <FormInput
                                                        className='form-control'
                                                        form={form}
                                                        name={`${index}.description`}
                                                        type="textarea"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    );
                                })
                            }

                            <div className="mb-3">
                                <button className="btn btn-info" onClick={() => form.setData([...form.data, {}])}>
                                    <Icon.Plus/>
                                    <span className="pl-1">Add</span>
                                </button>
                            </div>

                            <div className="mt-5">
                                <button className="btn btn-success" onClick={submitForm}>
                                    <Icon.Save/>
                                    <span className="pl-1">Save</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </TrenchDevsAdminLayout>
    )
}
