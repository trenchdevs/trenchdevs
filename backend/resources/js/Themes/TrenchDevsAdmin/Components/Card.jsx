export default function Card({header = null, ...props}) {
    return (
        <div className="card">
            <div className="card-header">{header}</div>
            <div className="card-body">
                {props.children}
            </div>
        </div>
    );
}
