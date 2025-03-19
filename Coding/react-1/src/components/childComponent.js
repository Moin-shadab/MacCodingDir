import './ChildComponent.css'
import FifthComponent from './FifthComponent';
import FourthComponent from './FourthComponent';
import GrandChildComponent from './GrandChildComponent';
function ChildComponent(){
    return(
        <div className="ChildComponent"><h2>ChildComponent</h2>
        <img src="https://img.freepik.com/free-vector/hand-drawn-web-developers_23-2148819604.jpg"></img>
        <GrandChildComponent/>
        <FourthComponent/>  
        <FifthComponent/>
        </div>
    );
}
export default ChildComponent;