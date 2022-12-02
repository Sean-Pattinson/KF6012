import React from 'react';

class Content_Authors extends React.Component {

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
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/authors?content_id=" + this.props.contentId
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

    handleContentClick = (e) => {
    }


    render() {

        let authors = ''
        if (this.state.data.length !== 0) {
            authors = this.state.data.map((author, i) => {
                if (i < this.state.data.length - 1) {
                    return author.name + ', ';
                } else {
                    return author.name + '.'
                }
            })
            authors = <div>Authors: {authors} </div>
        }

        return (
            <div>
               {authors}
            </div>
        )
    }
}

export default Content_Authors;