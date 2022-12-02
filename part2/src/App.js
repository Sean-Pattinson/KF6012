import React from "react";
import { BrowserRouter as Router, Switch, Route, Link, NavLink } from "react-router-dom";
import Sessions from './components/Sessions.js';
import Authors from './components/Authors.js';
import NotFound404 from './components/NotFound404.js';
import Admin from './components/Admin.js';
import Schedule from "./components/Schedule.js";
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
                      <Link to="/KF6012/part2/">Home</Link>
                    </li>
                    <li>
                      <Link to="/KF6012/part2/sessions">Sessions</Link>
                    </li>
                    <li>
                      <Link to="/KF6012/part2/authors">Authors</Link>
                    </li>
                    <li>
                      <Link to="/KF6012/part2/admin">Admin</Link>
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
                            <NavLink activeClassName="selected" exact to="/KF6012/part2/">Home</NavLink>
                        </li>
                        <li>
                            <NavLink activeClassName="selected" to="/KF6012/part2/sessions">Sessions</NavLink>
                        </li>
                        <li>
                            <NavLink activeClassName="selected" to="/KF6012/part2/authors">Authors</NavLink>
                        </li>
                        <li>
                            <NavLink activeClassName="selected" to="/KF6012/part2/admin">Admin</NavLink>
                        </li>
                    </ul>
                </nav>
                <nav className="NarrowNav">
                    <ul>
                        <NarrowNav />
                    </ul>
                </nav>
                <Switch>
                    <Route path="/KF6012/part2/sessions/">
                        <Sessions />
                    </Route>
                    <Route path="/KF6012/part2/authors/">
                        <Authors />
                    </Route>
                    <Route path="/KF6012/part2/admin/">
                        <Admin />
                    </Route>
                    <Route exact path="/KF6012/part2/">
                        <h2>Schedule</h2>
                        <Schedule day='Monday' />
                        <Schedule day='Tuesday' />
                        <Schedule day='Wednesday' />
                        <Schedule day='Thursday' />
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
