import {isArray} from "lodash";
import * as Icon from "react-feather";
import FormInput from "@/Themes/TrenchDevsAdmin/Components/Forms/FormInput";

/**
 * @param {InertiaFormProps<TForm>} inertiaForm
 * @param {Object} formElements
 * @param onSubmit
 * @param entryVerbige
 * @param actions
 * @returns {JSX.Element}
 * @constructor
 */
export default function DynamicListForm({
                             inertiaForm,
                             formElements,
                             onSubmit,
                             entryVerbiage = 'Entry',
                             actions = {
                                 delete: true,
                                 arrows: true,
                                 add: true
                             }
                         }) {

    return (
        <>
            {/*<pre><code>{JSON.stringify(form.data, null, 4)}</code></pre>*/}
            {
                isArray(inertiaForm.data) &&
                inertiaForm.data.map((experience, index) => {
                    return (
                        <div className="mb-4 mx-1 px-2 py-4 row" key={index} style={{backgroundColor: '#ebebeb', borderRadius:'12px'}}>
                            <div className="col-md-12">
                                <h4>
                                    {entryVerbiage || 'Entry'} {index + 1}

                                    {
                                        !!actions.delete
                                        &&
                                        <button
                                            className="float-right btn mr-2 btn-sm btn-danger"
                                            onClick={() => {
                                                const copy = [...inertiaForm.data];
                                                copy.splice(index, 1);
                                                inertiaForm.setData([...copy]);
                                            }}
                                        >
                                            <Icon.Trash/>
                                        </button>
                                    }


                                    <>
                                        {
                                            !!actions.arrows &&
                                            index !== 0 &&
                                            <button
                                                className="float-right mr-2 btn-sm btn btn-info"
                                                onClick={() => {
                                                    const copy = [...inertiaForm.data];
                                                    const temp = inertiaForm.data[index - 1]
                                                    copy[index - 1] = inertiaForm.data[index];
                                                    copy[index] = temp;
                                                    inertiaForm.setData([...copy]);
                                                }}
                                            >
                                                <Icon.ArrowUp/>
                                            </button>
                                        }

                                        {
                                            !!actions.arrows &&
                                            index !== inertiaForm.data.length - 1 &&
                                            <button
                                                className="float-right mr-2 btn-sm btn btn-info"
                                                onClick={() => {
                                                    const copy = [...inertiaForm.data];
                                                    const temp = inertiaForm.data[index + 1]
                                                    copy[index + 1] = inertiaForm.data[index];
                                                    copy[index] = temp;
                                                    inertiaForm.setData([...copy]);
                                                }}
                                            >
                                                <Icon.ArrowDown/>
                                            </button>
                                        }
                                    </>
                                </h4>
                            </div>


                            {
                                Object.keys(formElements).map((formKey) => {
                                    const {wrapperClassName = '', name, ...formInputProps} = formElements[formKey]

                                    return (
                                        <div className={wrapperClassName} key={`${index}-${formKey}`}>
                                            <div className="form-group">
                                                <label>{formKey}</label>
                                                <FormInput
                                                    {...formInputProps}
                                                    name={(name || '').replace('*', index)}
                                                    form={inertiaForm}
                                                />
                                            </div>
                                        </div>
                                    )
                                })
                            }

                        </div>
                    );
                })
            }

            {
                actions.add &&
                <div className="mb-3">
                    <button className="btn btn-info" onClick={() => inertiaForm.setData([...inertiaForm.data, {}])}>
                        <Icon.Plus/>
                        <span className="pl-1">Add</span>
                    </button>
                </div>
            }

            <div className="mt-5">
                <button className="btn btn-success" onClick={onSubmit}>
                    <Icon.Save/>
                    <span className="pl-1">Save</span>
                </button>
            </div>

        </>
    );
}
