import React, {useEffect} from 'react';
import TrenchDevsAdminLayout from '@/Layouts/Themes/TrenchDevsAdminLayout';
import { Head } from '@inertiajs/inertia-react';

export default function Dashboard(props) {

    const MAP = {
        'demo' : TrenchDevsAdminLayout,
    };

    const Layout = MAP['demo'];

    return (
        <Layout
            auth={props.auth}
            errors={props.errors}
            // header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
        >
            here
            {/*<Head title="Dashboard" />*/}

            {/*<div className="py-12">*/}
            {/*    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">*/}
            {/*        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">*/}
            {/*            <div className="p-6 bg-white border-b border-gray-200">You're logged in!</div>*/}
            {/*        </div>*/}
            {/*    </div>*/}
            {/*</div>*/}
        </Layout>
    );
}
