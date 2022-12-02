import React from 'react';
import Content from './Content.js';
import Chair from './Chair.js';

class Session extends React.Component {

    state = {
        display:false,
        displayFurther:false,
        data: []
    }

    loadPresentationDetails = () => {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/content?session_id=" + this.props.details.session_id
        fetch(url)
            .then( (response) => response.json() )
            .then( (data) => {
                this.setState({data:data.data});
            })
            .catch ((err) => {
                    console.log("something went wrong ", err)
                }
            );
    };

    handleSessionClick = (e) => {
        this.setState({display:!this.state.display})
    }

    handleLocationClick = () => {
        this.setState({displayFurther:!this.state.displayFurther})
        this.loadPresentationDetails()
    }




    render() {

        let info = "";
        let furtherInfo = "";

        if (this.state.displayFurther) {
                furtherInfo = this.state.data.map( (details, i) => (<Content key={i} details={details} />) )
        }

        if (this.state.display) {



            info = <div className='info' onClick={this.handleLocationClick}>Location: {this.props.details.room}
                <Chair session_id={this.props.details.session_id} />
                {furtherInfo}
            </div>

        }


        return (
            <div className='info collapsible'>
                <h3 onClick={this.handleSessionClick}>{this.props.details.session}</h3>
                {info}

            </div>
        );
    }
}

export default Session;