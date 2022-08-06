import {isEmpty} from "lodash";
import FormInput from "@/Themes/TrenchDevsAdmin/Components/FormInput";
import * as Icon from "react-feather";
import React from "react";

export default function DynamicForm({
                                        inertiaForm,
                                        formElements,
                                        onSubmit,
                                    }) {

    if (isEmpty(formElements)) {
        return <></>
    }

    return (
        <>

            <div className="row">
                {
                    Object.keys(formElements).map((formKey) => {
                        const {wrapperClassName = '', name, ...formInputProps} = formElements[formKey]

                        return (
                            <div className={wrapperClassName} key={formKey}>
                                <div className="form-group">
                                    <label>{formKey}
                                        {
                                            formInputProps.verbiage &&
                                            <small className="ml-1">({formInputProps.verbiage})</small>
                                        }
                                    </label>

                                    <FormInput
                                        {...formInputProps}
                                        name={name}
                                        form={inertiaForm}
                                    />
                                </div>
                            </div>
                        )
                    })
                }
            </div>

            <div className="row">
                <div className="col">
                    <div className="mt-3">
                        <button className="btn btn-success" onClick={onSubmit}>
                            <Icon.Save/>
                            <span className="pl-1">Save</span>
                        </button>
                    </div>
                </div>
            </div>
        </>
    );
}
