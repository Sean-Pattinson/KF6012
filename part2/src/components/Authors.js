import React from 'react';
import Author from './Author.js';
import Search from './Search.js';

class Authors extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            page:1,
            pageSize:10,
            query:"",
            data:[]
        }
    }

    componentDidMount() {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/authors"
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

    handlePreviousClick = () => {
        this.setState({page:this.state.page-1})
    }

    handleNextClick = () => {
        this.setState({page:this.state.page+1})
    }

    handleSearch = (e) => {
        this.setState({page:1,query:e.target.value})
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/authors?search=" + e.target.value
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
        return ((this.searchString(details.name)))
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
                <h1>Authors</h1>
                <Search query={this.state.query} handleSearch={this.handleSearch}/>
                {
                    filteredData
                        .slice(((this.state.pageSize*this.state.page)-this.state.pageSize),(this.state.pageSize*this.state.page))
                        .map( (details, i) => (<Author key={i} details={details} />) )
                }
                <button onClick={this.handlePreviousClick} disabled={disabledPrevious}>Previous</button>
                Page {this.state.page} of {noOfPages}
                <button onClick={this.handleNextClick} disabled={disabledNext}>Next</button>
            </div>
        );
    }
}

export default Authors;