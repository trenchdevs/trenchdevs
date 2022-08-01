import {isArray, isEmpty} from "lodash";
import {Link} from "@inertiajs/inertia-react";

export default function Paginator({links}) {

    if (isEmpty(links) || !isArray(links)) {
        return <></>
    }

    return (
        <nav className="mt-5">
            <ul className="pagination float-right">
                {
                    links.map(({url, label, active}) =>
                        (
                            <li key={label}
                                className={`page-item ${active && 'active'} ${!url && 'disabled'}`}>
                                <Link className={`page-link`} href={url}>
                                    <span dangerouslySetInnerHTML={{__html: label}}/></Link>

                            </li>
                        )
                    )}
            </ul>
        </nav>
    );

}
