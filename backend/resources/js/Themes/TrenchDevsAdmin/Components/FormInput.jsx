import {get, isArray, set, isObject} from "lodash";

/**
 * @param name
 * @param {InertiaFormProps} form
 * @param props
 * @returns {JSX.Element}
 * @constructor
 */
export default function FormInput({name, form, ...props}) {

    function onChange(e) {
        let formData;

        if (isArray(form.data)) {
            formData = [...form.data];
        } else {
            formData = {...form.data};
        }

        form.setData(set(formData, name, e.target.value))
    }

    const sharedProps = {
        name,
        onChange,
        value: get(form.data, name, '') || '',
        ...props
    }

    function renderFormElement(){
        const inputType = sharedProps.type || 'input';
        switch (inputType) {
            case 'textarea':
                return <textarea {...sharedProps}/>
            case "input":
            default:
                return <input {...sharedProps} />
        }
    }

    return (
        <>
            {renderFormElement()}
            {
                isObject(form.errors) &&
                get(form.errors, name, false) &&
                <div className="text-danger">{get(form.errors, name, '')}</div>
            }
        </>
    );
}
