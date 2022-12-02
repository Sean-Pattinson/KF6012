import React from 'react';
import Content from './Content.js';


class Author extends React.Component {

    state = {display:false, data:[]}

    loadContentDetails = () => {
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/sessions_authors?author_id=" + this.props.details.author_id
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
        this.loadContentDetails()
    }

    render() {
        let presentations = ""

        if (this.state.display) {
            presentations = this.state.data.map( (details, i) => (<Content key={i} details={details} />) )
        }
        return (
            <div className='info'>
                <h2 onClick={this.handleAuthorClick}>{this.props.details.name}</h2>
                {presentations}
            </div>
        );
    }
}

export default Author;