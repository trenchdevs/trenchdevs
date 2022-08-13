import Card from "@/Themes/TrenchDevsAdmin/Components/Card";
import FormInput from "@/Themes/TrenchDevsAdmin/Components/Forms/FormInput";
import {useForm} from "@inertiajs/inertia-react";
import TrenchDevsAdminLayout from "@/Themes/TrenchDevsAdmin/Layouts/TrenchDevsAdminLayout";

export default function CreateAnnouncement() {

    const announcementForm = useForm({
        'title': '',
        'message': '',
        'emails': '',
    });

    function onSubmit() {
        announcementForm.post('/dashboard/announcements/create');
    }

    return (
        <TrenchDevsAdminLayout>
            <Card header={"Create Announcement"}>
                <div>
                    <div className="form-group">
                        <label htmlFor="title">Title / Subject</label>
                        <FormInput
                            name={"title"}
                            className={"form-control"}
                            form={announcementForm}
                            type={"input"}
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="message">Message</label>
                        <FormInput
                            name={"message"}
                            form={announcementForm}
                            type={"rich-text-editor"}
                        />
                    </div>

                    <div className="form-group">
                        <label htmlFor="emails">Email Addresses (CSV) </label>
                        <FormInput
                            className={"form-control"}
                            name={"emails"}
                            form={announcementForm}
                            type={"textarea"}
                        />
                    </div>

                    <div className="alert alert-info">
                        Note: If no emails are specified, by default this creates an activity feed and emails all
                        participants in the TrenchDevs account.
                    </div>

                    <div className="row">
                        <div className="col text-right">
                            <button className="btn btn-success" onClick={onSubmit}>Announce</button>
                        </div>
                    </div>
                </div>
            </Card>
        </TrenchDevsAdminLayout>
    );
}
