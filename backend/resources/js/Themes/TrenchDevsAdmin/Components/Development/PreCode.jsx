export default function PreCode({data}){
    return (
        <pre><code>{JSON.stringify(data, null, 4)}</code></pre>
    );
}
