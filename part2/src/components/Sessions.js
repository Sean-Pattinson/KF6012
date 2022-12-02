import React from 'react';
import Session from './Session.js';
import Search from './Search.js';

class Sessions extends React.Component {

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
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/sessions"
        fetch(url)
            .then( (response) => response.json())
            .then( (data) => {
                this.setState({data:data.data})
            })
            .catch ((err) => {
                    console.log("something went wrong ", err)
                }
            );
    }

    handlePreviousClick = () => {
        this.setState({page:this.state.page-1})
    }

    handleNextClick = () => {
        this.setState({page:this.state.page+1})
    }

    handleSearch = (e) => {
        this.setState({page:1,query:e.target.value})
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/sessions?search=" + e.target.value
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

    searchString = (s) => {
        return s.toLowerCase().includes(this.state.query.toLowerCase())
    }

    searchDetails = (details) => {
        return ((this.searchString(details.session)))
    }

    render() {

        let filteredData =  (
            this.state.data
                    .filter(this.searchDetails)
        )

        let noOfPages = Math.ceil(filteredData.length/this.state.pageSize)
        if (noOfPages === 0) {noOfPages=1}
        let disabledPrevious = (this.state.page <= 1)
        let disabledNext = (this.state.page >= noOfPages)

        return (
            <div className='info'>
                <h1>Sessions</h1>
                <Search query={this.state.query} handleSearch={this.handleSearch}/>
                {

                    filteredData
                        .slice(((this.state.pageSize*this.state.page)-this.state.pageSize),(this.state.pageSize*this.state.page))
                        .map( (details, i) => (<Session key={i} details={details} />) )
                }
                <button onClick={this.handlePreviousClick} disabled={disabledPrevious}>Previous</button>
                Page {this.state.page} of {noOfPages}
                <button onClick={this.handleNextClick} disabled={disabledNext}>Next</button>
            </div>
        );
    }
}

export default Sessions;