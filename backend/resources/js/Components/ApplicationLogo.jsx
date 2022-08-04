import React from 'react';
import {usePage} from "@inertiajs/inertia-react";

export default function ApplicationLogo({ className }) {

    const {site} = usePage().props;

    if (site.logo) {
        return <img className={className} src={site.logo} alt={`${site.company_name} logo.`}/>
    }

    return  <></>
}
