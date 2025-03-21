
const EventListners = () => {
    const sayHI = () => {
        alert("Hi Moin")
    }
    return(
        <div className="EventListners">
            <p id="AutoIncrementNumber" style={{fontSize:"5em"}} >0</p>
            <div style={{marginRight:"10px"}}>
            <button onClick={ () => sayHI() } >Increment</button>
            <button onClick={sayHI} >Decrement</button>
            </div>
        </div>
    );
}
export default EventListners;