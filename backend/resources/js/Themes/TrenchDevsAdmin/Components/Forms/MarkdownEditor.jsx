import MarkdownIt from 'markdown-it';
import MdEditor from 'react-markdown-editor-lite';

import 'react-markdown-editor-lite/lib/index.css';
const mdParser = new MarkdownIt();

export default function MarkdownEditor({onChange, value}) {

    function handleEditorChange({html, text}) {
        console.log('handleEditorChange', html, text);
        onChange(html, text);
    }

    return (
        <MdEditor
            style={{height: '500px'}}
            value={value}
            renderHTML={text => mdParser.render(text)}
            onChange={handleEditorChange}
        />
    )
}
