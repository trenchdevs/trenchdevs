import {get, isArray, set, isObject, isString} from "lodash";
import RichTextEditor from "@/Themes/TrenchDevsAdmin/Components/Forms/RichTextEditor";

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
        let value;

        if (isString(e)) {
            value = e;
        } else if (isObject(e)) {
            value = get(e, 'target.value', '')
        } else {
            value = '';
            console.error('td: element value not supported');
        }


        if (isArray(form.data)) {
            // e.g. Use in DynamicListForm
            formData = [...form.data];
            form.setData(set(formData, name, value))
        } else {
            // e.g. Use in DynamicForm
            form.setData({
                ...form.data,
                [name]: value,
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
                            dropdownOptions.map((option,index, i) => (
                                <option key={`${name}-${index}`} value={option.value || ''}>{option.label || ''}</option>
                            ))
                        }
                    </select>
                )
            case 'rich-text-editor':
                return <RichTextEditor {...sharedProps} />
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
