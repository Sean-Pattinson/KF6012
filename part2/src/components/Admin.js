import React from 'react';
import Login from './Login.js';
import Update from './Update.js';

class Admin extends React.Component {


    state = {"email":"", "password":""}

    postData = (url, myJSON, callback) => {
        fetch(url, {   method: 'POST',
            headers : new Headers(),
            body:JSON.stringify(myJSON)})
            .then( (response) => response.json() )
            .then( (data) => {
                callback(data)
            })
            .catch ((err) => {
                    console.log("something went wrong ", err)
                }
            );
    }

    loginCallback = (data) => {
        console.log(data)
        if (data.status === 200) {
            localStorage.setItem('myToken', data.token);
            window.location.reload()
        }
    }

    updateCallback = (data) => {
        console.log(data)
        if (data.status !== 200) {
            localStorage.removeItem('myToken')
        }
        window.location.reload()
    }

    handleLoginClick = () => {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/login"
        let myJSON = {"email":this.state.email, "password":this.state.password}
        this.postData(url, myJSON, this.loginCallback)
    }

    handleUpdateClick = (session_id, description) => {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/update"
        if (localStorage.getItem('myToken')) {
            let myToken = localStorage.getItem('myToken')
            let myJSON = {
                "token":myToken,
                "session_id": session_id,
                "description":description
            }
            this.postData(url, myJSON, this.updateCallback)
        } else {
            localStorage.removeItem('myToken')
        }
    }

    handleLogoutClick = () => {
        this.setState({"password":undefined})
        localStorage.removeItem('myToken');
    }

    handlePassword = (e) => {
        this.setState({password:e.target.value})
    }
    handleEmail = (e) => {
        this.setState({email:e.target.value})
    }

    constructor(props) {
        super(props);
        this.state = {"email":"", "password":""}

        this.handleEmail = this.handleEmail.bind(this);
        this.handlePassword = this.handlePassword.bind(this);

    }

    render() {
        const auth = localStorage.getItem('myToken')

        let page = <Login handleLoginClick={this.handleLoginClick} email={this.state.email} password={this.props.password} handleEmail={this.handleEmail} handlePassword={this.handlePassword}/>
        if (auth) {
            page = <div>
                <button onClick={this.handleLogoutClick}>Log out</button>
                <Update handleUpdateClick={this.handleUpdateClick} />
            </div>
        }

        return (
            <div className='info'>
                <h1>Admin</h1>
                {page}
            </div>
        );
    }
}

export default Admin;