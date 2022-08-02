import {get, isEmpty, isObject} from "lodash";

/**
 * @param name
 * @param {InertiaFormProps} form
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
export default function FormInput({name, form, ...props}) {

    return (
        <>
            <input name={name} {...props} value={form.data[name] || ''} onChange={e => form.setData(name, e.target.value)} />
            {
                isObject(form.errors) &&
                form.errors[name] &&
                <div className="text-danger">{form.errors[name]}</div>
            }
        </>
    );
}
