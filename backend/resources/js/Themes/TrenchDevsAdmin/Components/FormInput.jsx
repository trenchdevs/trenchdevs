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
            // e.g. Use in DynamicListForm
            formData = [...form.data];
            form.setData(set(formData, name, e.target.value))
        } else {
            // e.g. Use in DynamicForm
            form.setData({
                ...form.data,
                [name]: e.target.value,
            })
        }

    }

    const sharedProps = {
        ...props,
        name,
        onChange,
        value: get(form.data, name, '') || '',
    }

    function renderFormElement() {
        const inputType = sharedProps.type || 'input';
        switch (inputType) {
            case 'textarea':
                return <textarea {...sharedProps}/>
            case 'select':
                const dropdownOptions = props.dropdown_options || [];
                return (
                    <select {...sharedProps}>
                        {
                            dropdownOptions.map((option, i) => (
                                <option value={option.value || ''}>{option.label || ''}</option>
                            ))
                        }
                    </select>
                )
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
