import FormInput from "@/Themes/TrenchDevsAdmin/Components/FormInput";
import {useForm} from "@inertiajs/inertia-react";
import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import * as Icon from 'react-feather';

const FORM_INITIAL_VALUES = {
    old_password: '',
    password: '',
    password_confirmation: '',
};

export default function ChangePassword(props) {

    const form = useForm({...FORM_INITIAL_VALUES});

    function submitForm(e) {
        e.preventDefault();
        form.post('/dashboard/account/change-password');
        form.reset();
    }

    return (
        <TrenchDevsAdminLayout>

            <div className="row mb-3">
                <div className="col">
                    <nav className="nav nav-borders">

                        <a className="p-0 nav-link active" href="">
                            <div className="badge badge-blue-soft p-3">
                                <span className="font-weight-bolder"><Icon.Lock className="d-inline mr-2" size={12}/>Security</span>
                            </div>
                        </a>
                    </nav>
                </div>
            </div>

            <div className="row">
                <div className="col-6">
                    <div className="card mb-4">
                        <div className="card-header">
                            Change Password
                        </div>
                        <div className="card-body p-5">

                            <form onSubmit={submitForm}>
                                <div className="form-group">
                                    <label htmlFor="old_password">Old Password</label>
                                    <FormInput form={form} name={'old_password'} className="form-control"
                                               type="password"/>
                                </div>

                                <div className="form-group">
                                    <label htmlFor="password">Password</label>
                                    <FormInput form={form} name={'password'} className="form-control" type="password"/>
                                </div>

                                <div className="form-group">
                                    <label htmlFor="password_confirmation">Confirm Password</label>
                                    <FormInput form={form} name={'password_confirmation'} className="form-control"
                                               type="password"/>
                                </div>

                                <button className="btn btn-success float-right"><Icon.Save className="mr-2"
                                                                                           size={16}/> Save
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </TrenchDevsAdminLayout>
    );
}
