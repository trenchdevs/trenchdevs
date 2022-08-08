import Paginator from "@/Themes/TrenchDevsAdmin/Components/Paginator";
import {isFunction} from "lodash";

export default function CustomTable({
                                        columns = [],
                                        rows = [],
                                        links = [],
                                    }) {
    return (
        <div className="row">
            <div className="col">
                <table className="table table-striped">

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
                                    } else {
                                        toRender = row[column.key] || '';
                                    }

                                    return <td key={colKey}>{toRender}</td>
                                })}
                            </tr>
                        );
                    })}
                    </tbody>
                </table>

                <Paginator links={links}/>
            </div>
        </div>
    )
}