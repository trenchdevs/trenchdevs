import React from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/inertia-react';

export default function Guest({ children }) {
    return (
        <div className="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white-25">
            <div className="p-3">
                <Link href="/">
                    <ApplicationLogo className="w-48 h-25 fill-current text-gray-500 img-thumbnail"/>
                </Link>
            </div>

            <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg bg-white">
                {children}
            </div>
        </div>
    );
}
