import './App.css';
import EventListners from './components/eventListners/EventListners';
import Parameters from './components/params/Parameters';

function App() {
  let ArrDetails = {
    name :"TestName",
    age: "25",
    place:"ABC"
  }
  return (
    <div className="App">
      <p id="Name" >Moin Shadab</p>
      <EventListners />
      <Parameters  details = {ArrDetails} />
    </div>
  );
}

export default App;
