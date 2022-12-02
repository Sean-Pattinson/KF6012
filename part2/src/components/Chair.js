import React from 'react';

class Chair extends React.Component {

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
        const url = "http://unn-w16004894.newnumyspace.co.uk/KF6012/part1/api/chairs?session_id=" + this.props.session_id
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

    render() {
        let chair = ''

        if(this.state.data.length !== 0) {
            this.state.data.map((chairs, i) => {
                if (chairs.length !== 0) {
                    (chair = <div>Chair: {chairs.name}.</div>)
                }


            })
        }

        return (
            <div>
                {chair}
            </div>
        )
    }
}

export default Chair;