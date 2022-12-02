import React from 'react';
import Slot from "./Slot.js";

class Slots extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            page:1,
            pageSize:9,
            query:"",
            data:[]
        }
    }

    componentDidMount() {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/slots"
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

    loadSlots = (day) => {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/slots?dayString=" + day
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
            let dayString = '';
            dayString=e.target.dataset.day
            switch(dayString) {
                case 'Monday' :
                    this.setState({displayDay1:!this.state.displayDay1})
                    break;
                case 'Tuesday' :
                    this.setState({displayDay2:!this.state.displayDay2})
                    break;
                case 'Wednesday' :
                    this.setState({displayDay3:!this.state.displayDay3})
                    break;
                case 'Thursday' :
                    this.setState({displayDay2:!this.state.displayDay2})
                    break;
                default:
                    console.log('Error: the day seems to be missing')
            }
        this.loadSlots(dayString)
    }

    render() {

        let day= ''

        if (this.state.displayDay1) {
            day=<div>{this.state.data.map((details,i) => (<Slot key={i} details={details}/>))}</div>
    }

        if (this.state.displayDay2) {
            day=<div>{this.state.data.map((details,i) => (<Slot key={i} details={details}/>))}</div>
        }


        return (
            <div>
                <h2>Schedule</h2>
                <h3 onClick={this.handleDayClick} data-day='Monday'>Monday</h3>
                {day}
                <h3 onClick={this.handleDayClick} data-day='Tuesday'>Tuesday</h3>
                {day}
            </div>
        )
    }
}

export default Slots;