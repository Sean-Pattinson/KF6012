import React from 'react';
import Content_Authors from "./Content_Authors.js";

class Content extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            page:1,
            pageSize:9,
            query:"",
            data:[]
        }
    }

    render() {

        let awards = '';
        let abstract = '';

        if (this.props.details.award !== undefined && this.props.details.award !=='') {
            awards = <p>Awards: {this.props.details.award}</p>
            }

        if (this.props.details.abstract !== undefined && this.props.details.abstract !=='') {
            abstract = <p>Abstract: {this.props.details.abstract}</p>
        }

        return (
            <div className='info'>
                <p>Session: {this.props.details.session}</p>
                <p >Presentation: {this.props.details.title}</p>
                <Content_Authors contentId={this.props.details.contentId}/>
                {abstract}
                {awards}
            </div>
        )
    }
}

export default Content;