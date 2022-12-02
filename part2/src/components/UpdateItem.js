import React from 'react';

class UpdateItem extends React.Component {

    state = {description: this.props.details.session}

    handleDescriptionChange = (e) => {
        this.setState({description:e.target.value})
    }

    handleDescriptionUpdate = () => {
        this.props.handleUpdateClick(this.props.details.session_id, this.state.description)
    }

    render() {
        return (
            <div className='info'>
                <h4>{this.props.details.session}</h4>
                <p>Title:</p>
                <textarea
                    rows="2" cols="50"
                    value={this.state.description}
                    onChange={this.handleDescriptionChange}
                />
                <button onClick={this.handleDescriptionUpdate}>Update</button>
            </div>
        );
    }
}

export default UpdateItem;