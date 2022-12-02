import React from "react";
import { BrowserRouter as Router, Switch, Route, Link, NavLink } from "react-router-dom";
import Films from './components/Films.js';
import Actors from './components/Actors.js';
import NotFound404 from './components/NotFound404.js';
import Home from './components/Home.js'
import Admin from './components/Admin.js';
import './App.css';

class NarrowNav extends React.Component {
    state = {expanded:true}

    toggle = () => {
      this.setState({expanded:!this.state.expanded})
    }

    render() {

        let nav = ""

        if (this.state.expanded) {
            nav = <div>
                    <li>
                      <Link to="/">Home</Link>
                    </li>
                    <li>
                      <Link to="/films">Films</Link>
                    </li>
                    <li>
                      <Link to="/actors">Actors</Link>
                    </li>
                    <li>
                      <Link to="/admin">Admin</Link>
                    </li>
                   </div>
                }

        return (
          <div>
            <button onClick={this.toggle}>Menu</button>
            {nav}
          </div>
              )
    }
}



function App() {
    return (
        <Router>
            <div className="App">
                <nav className="WideNav">
                    <ul>
                        <li>
                            <NavLink activeClassName="selected" exact to="/">Home</NavLink>
                        </li>
                        <li>
                            <NavLink activeClassName="selected" to="/films">Films</NavLink>
                        </li>
                        <li>
                            <NavLink activeClassName="selected" to="/actors">Actors</NavLink>
                        </li>
                        <li>
                            <NavLink activeClassName="selected" to="/admin">Admin</NavLink>
                        </li>
                    </ul>
                </nav>
                <nav className="NarrowNav">
                    <ul>
                        <NarrowNav />
                    </ul>
                </nav>
                <Switch>
                    <Route path="/films">
                        <Films />
                    </Route>
                    <Route path="/actors">
                        <Actors />
                    </Route>
                    <Route path="/admin">
                        <Admin />
                    </Route>
                    <Route exact path="/">
                        <Home />
                    </Route>
                    <Route path="*">
                        <NotFound404 />
                    </Route>
                </Switch>
            </div>
        </Router>
    );
}

export default App;
