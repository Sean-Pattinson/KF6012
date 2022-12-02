import React from 'react';
import Session from './Session.js';


class Slot extends React.Component {

    state = {display:false, data:[]}

    loadSessionDetails = () => {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/sessions?slot_id=" + this.props.details.slotId
        fetch(url)
            .then( (response) => response.json() )
            .then( (data) => {
                this.setState({data:data.data});
            })
            .catch ((err) => {
                    console.log("something went wrong ", err)
                }
            );
    }

    handleAuthorClick = (e) => {
        this.setState({display:!this.state.display})
        this.loadSessionDetails()
    }

    render() {

        let sessions = ""
        let startMinute = this.props.details.startMinute
        let endMinute = this.props.details.endMinute

        if (this.state.display) {
            sessions = this.state.data.map( (details, i) => (<Session key={i} details={details} />) )

        }

        if(this.props.details.startMinute === '0') {
            startMinute = this.props.details.startMinute + '0'
        }

        if(this.props.details.endMinute === '0') {
            endMinute = this.props.details.endMinute + '0'
        }

        return (
            <div className='info'>
                <h3 onClick={this.handleAuthorClick}>{this.props.details.startHour}:{startMinute} - {this.props.details.endHour}:{endMinute}</h3>
                {sessions}
            </div>
        );
    }
}

export default Slot;