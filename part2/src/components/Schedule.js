import React from 'react';
import Slot from "./Slot.js";

class Schedule extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            page:1,
            pageSize:9,
            query:"",
            display:"",
            data:[]
        }
    }

    loadSlots = () => {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/slots?dayString=" + this.props.day
        fetch(url)
            .then( (response) => response.json() )
            .then( (data) => {
                this.setState({data:data.data})
            })
            .catch ((err) => {
                    console.log("something went wrong ", err)
                }
            );
    }


    handleDayClick = (e) => {
        this.setState({display:!this.state.display})
        this.loadSlots()
    }

    render() {

        let schedule = ''

        if (this.state.display) {
                schedule=<div>{this.state.data.map((details,i) => (<Slot key={i} details={details}/>))}</div>
        }


        return (
            <div className='info'>
                <h3 onClick={this.handleDayClick}>{this.props.day}</h3>
                {schedule}
            </div>


        )
    }
}

export default Schedule;