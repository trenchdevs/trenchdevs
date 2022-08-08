import {CKEditor} from '@ckeditor/ckeditor5-react';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

/**
 * @param value
 * @param onChange
 * @returns {JSX.Element}
 * @constructor
 */
export default function RichTextEditor({
                                       value = '',
                                       onChange
                                   }) {
    return (
        <CKEditor
            editor={ClassicEditor}
            data={value}
            onReady={editor => {
                // You can store the "editor" and use when it is needed.
            }}
            onChange={(event, editor) => {
                onChange(editor.getData() || '');
            }}
            onBlur={(event, editor) => {
            }}
            onFocus={(event, editor) => {
            }}
        />
    );
}
