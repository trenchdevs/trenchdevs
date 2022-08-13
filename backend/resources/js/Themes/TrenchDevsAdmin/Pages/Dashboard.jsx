import React from 'react';
import TrenchDevsAdminLayout from '@/Themes/TrenchDevsAdmin/Layouts/TrenchDevsAdminLayout';

export default function Dashboard(props) {

    return (
        <TrenchDevsAdminLayout
            auth={props.auth}
            errors={props.errors}
        >
            <h2>Dashboard</h2>
        </TrenchDevsAdminLayout>
    );
}
