import {isFunction} from "lodash";
import InertiaPaginator from "./InertiaPaginator";

export default function InertiaTable({
                                         columns = [],
                                         rows = [],
                                         links = [],
                                         ...props
                                     }) {
    return (
        <div className="row">
            <div className="col">
                <table
                    className="table table-striped table-responsive overflow-x-auto"
                    // style={{display: "block"}}
                >

                    <thead>
                    <tr>
                        {columns.map((column, key) => <th key={key + column.label}>{column.label}</th>)}
                    </tr>
                    </thead>

                    <tbody>
                    {rows.map((row, index) => {

                        const rowKey = row.id || index;

                        return (
                            <tr key={rowKey}>
                                {columns.map((column, columnKey) => {
                                    const colKey = rowKey + columnKey;

                                    let toRender;

                                    if (column.render && isFunction(column.render)) {
                                        toRender = column.render(row) || '';
                                    } else if (column.type) {

                                        switch (column.type) {
                                            case 'image':
                                                toRender = (
                                                    <img className="img-thumbnail img-fluid"
                                                         style={{maxHeight: '50px'}}
                                                         src={row[column.key] || ''} alt={row.title}
                                                    />
                                                )
                                                break;
                                            case 'external_link':
                                                toRender = (
                                                    <a href={row[column.key] || ''} target="_blank">
                                                        {row[column.key]}
                                                    </a>
                                                )
                                                break;

                                            default:
                                                toRender = <>type not supported.</>
                                        }

                                    } else {
                                        toRender = row[column.key] || '';
                                    }

                                    return (
                                        <td
                                            style={column.style || {}}
                                            key={colKey}
                                        >
                                            {toRender}
                                        </td>
                                    )
                                })}
                            </tr>
                        );
                    })}
                    </tbody>
                </table>

                <InertiaPaginator links={links}/>
            </div>
        </div>
    )
}
