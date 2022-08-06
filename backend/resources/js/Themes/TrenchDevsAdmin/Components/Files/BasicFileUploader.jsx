import Dropzone from "react-dropzone";
import React from "react";

export default function BasicFileUploader({
                                              onUpload,
                                              maxFiles = 1,
                                              accept = "'image/*'",
                                              children = null,
                                              sectionClassName = '',
                                          }) {

    if (!children) {
        children = (
            <p className="border border-dark border-dashed mt-4 p-5 rounded text-center cursor-pointer">
                Drag 'n' drop some files here, or click to select files
            </p>
        );
    }

    return (
        <>
            <Dropzone onDrop={onUpload} maxFiles={maxFiles} >
                {({getRootProps, getInputProps}) => (
                    <section className={sectionClassName}>
                        <div {...getRootProps()}>
                            <input {...getInputProps()} accept={accept}/>
                            {children}
                        </div>
                    </section>
                )}
            </Dropzone>
        </>
    );
}
