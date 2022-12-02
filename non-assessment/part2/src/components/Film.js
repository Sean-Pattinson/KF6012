import React from 'react';

class Film extends React.Component {

    state = {
        display:false,
        displayFurther:false
    }

    handleFilmClick = () => {
        this.setState({display:!this.state.display})
    }

    handleInfoClick = () => {
        this.setState({displayFurther:!this.state.displayFurther})
    }

    render() {

        let info = "";
        let furtherInfo = "";

        if (this.state.displayFurther) {
            furtherInfo = <p>Room: {this.props.details.room} Rating: {this.props.details.rating}</p>
        }

        if (this.state.display) {
            info = <div>
                <p onClick={this.handleInfoClick}>{this.props.details.room}</p>
                {furtherInfo}
            </div>
        }

        return (
            <div>
                <h2 onClick={this.handleFilmClick}>{this.props.details.room}</h2>
                {info}
            </div>
        );
    }
}

export default Film;