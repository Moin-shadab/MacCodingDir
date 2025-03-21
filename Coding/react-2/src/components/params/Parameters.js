const Parameters = ({ details }) => {
    console.log(details);
    return (
        <div className="Parameters">
            <h1>Array details</h1>
            <ul>
                <li>{details.name}</li>
                <li>{details.age}</li>
                <li>{details.place}</li>
            </ul>
        </div>
    );
}

export default Parameters;
