import React from 'react';
import './App.css';

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
            furtherInfo = <p>Language: {this.props.details.language} Rating: {this.props.details.rating}</p>
        }

        if (this.state.display) {
            info = <div>
                <p onClick={this.handleInfoClick}>{this.props.details.description}</p>
                {furtherInfo}
            </div>
        }

        return (
            <div>
                <h2 onClick={this.handleFilmClick}>{this.props.details.title}</h2>
                {info}
            </div>
        );
    }
}

class Films extends React.Component {

    state = {
        page:1,
        pageSize:9,
        query:"",
        rating:"",
        language:"",
        data : [
            {
                "title": "CONFUSED CANDLES",
                "description": "A Stunning Epistle of a Cat And a Forensic Psychologist who must Confront a Pioneer in A Baloon",
                "rating": "12",
                "language": "English"
            }, {
                "title": "CONGENIALITY QUEST",
                "description": "A Touching Documentary of a Cat And a Pastry Chef who must Find a Lumberjack in A Baloon",
                "rating": "12",
                "language": "Japanese"
            }, {
                "title": "CONNECTICUT TRAMP",
                "description": "A Unbelieveable Drama of a Crocodile And a Mad Cow who must Reach a Dentist in A Shark Tank",
                "rating": "18",
                "language": "English"
            }, {
                "title": "CONNECTION MICROCOSMOS",
                "description": "A Fateful Documentary of a Crocodile And a Husband who must Face a Husband in The First Manned Space Station",
                "rating": "U",
                "language": "English"
            }, {
                "title": "CONQUERER NUTS",
                "description": "A Taut Drama of a Mad Scientist And a Man who must Escape a Pioneer in An Abandoned Mine Shaft",
                "rating": "U",
                "language": "German"
            }, {
                "title": "CONSPIRACY SPIRIT",
                "description": "A Awe-Inspiring Story of a Student And a Frisbee who must Conquer a Crocodile in An Abandoned Mine Shaft",
                "rating": "12",
                "language": "English"
            }, {
                "title": "CONTACT ANONYMOUS",
                "description": "A Insightful Display of a A Shark And a Monkey who must Face a Database Administrator in Ancient India",
                "rating": "12",
                "language": "French"
            }, {
                "title": "CONTROL ANTHEM",
                "description": "A Fateful Documentary of a Robot And a Student who must Battle a Cat in A Monastery",
                "rating": "U",
                "language": "English"
            }, {
                "title": "CONVERSATION DOWNHILL",
                "description": "A Taut Character Study of a Husband And a Waitress who must Sink a Squirrel in A MySQL Convention",
                "rating": "18",
                "language": "Mandarin"
            }, {
                "title": "CORE SUIT",
                "description": "A Unbelieveable Tale of a Car And a Explorer who must Confront a Boat in A Manhattan Penthouse",
                "rating": "12",
                "language": "English"
            }, {
                "title": "COWBOY DOOM",
                "description": "A Astounding Drama of a Boy And a Lumberjack who must Fight a Butler in A Baloon",
                "rating": "PG",
                "language": "Italian"
            }, {
                "title": "CRAFT OUTFIELD",
                "description": "A Lacklusture Display of a Explorer And a Hunter who must Succumb a Database Administrator in A Baloon Factory",
                "rating": "15",
                "language": "English"
            }, {
                "title": "CRANES RESERVOIR",
                "description": "A Fanciful Documentary of a Teacher And a Dog who must Outgun a Forensic Psychologist in A Baloon Factory",
                "rating": "15",
                "language": "Italian"
            }, {
                "title": "CRAZY HOME",
                "description": "A Fanciful Panorama of a Boy And a Woman who must Vanquish a Database Administrator in The Outback",
                "rating": "PG",
                "language": "English"
            }, {
                "title": "CREATURES SHAKESPEARE",
                "description": "A Emotional Drama of a Womanizer And a Squirrel who must Vanquish a Crocodile in Ancient India",
                "rating": "15",
                "language": "French"
            }, {
                "title": "CREEPERS KANE",
                "description": "A Awe-Inspiring Reflection of a Squirrel And a Boat who must Outrace a Car in A Jet Boat",
                "rating": "15",
                "language": "English"
            }, {
                "title": "CROOKED FROGMEN",
                "description": "A Unbelieveable Drama of a Hunter And a Database Administrator who must Battle a Crocodile in An Abandoned Amusement Park",
                "rating": "12",
                "language": "English"
            }, {
                "title": "CROSSING DIVORCE",
                "description": "A Beautiful Documentary of a Dog And a Robot who must Redeem a Womanizer in Berlin",
                "rating": "18",
                "language": "English"
            }, {
                "title": "CROSSROADS CASUALTIES",
                "description": "A Intrepid Documentary of a Sumo Wrestler And a Astronaut who must Battle a Composer in The Outback",
                "rating": "U",
                "language": "English"
            }, {
                "title": "CROW GREASE",
                "description": "A Awe-Inspiring Documentary of a Woman And a Husband who must Sink a Database Administrator in The First Manned Space Station",
                "rating": "PG",
                "language": "English"
            }, {
                "title": "CROWDS TELEMARK",
                "description": "A Intrepid Documentary of a Astronaut And a Forensic Psychologist who must Find a Frisbee in An Abandoned Fun House",
                "rating": "18",
                "language": "French"
            }, {
                "title": "CRUELTY UNFORGIVEN",
                "description": "A Brilliant Tale of a Car And a Moose who must Battle a Dentist in Nigeria",
                "rating": "U",
                "language": "English"
            }, {
                "title": "CRUSADE HONEY",
                "description": "A Fast-Paced Reflection of a Explorer And a Butler who must Battle a Madman in An Abandoned Amusement Park",
                "rating": "18",
                "language": "Italian"
            }, {
                "title": "CRYSTAL BREAKING",
                "description": "A Fast-Paced Character Study of a Feminist And a Explorer who must Face a Pastry Chef in Ancient Japan",
                "rating": "15",
                "language": "Italian"
            }, {
                "title": "CUPBOARD SINNERS",
                "description": "A Emotional Reflection of a Frisbee And a Boat who must Reach a Pastry Chef in An Abandoned Amusement Park",
                "rating": "18",
                "language": "Japanese"
            }
        ]
    }

    handleNextClick = () => {
        this.setState({page:this.state.page+1})
    }

    handlePreviousClick = () => {
        this.setState({page:this.state.page-1})
    }

    handleSearch = (e) => {
        this.setState({page:1, query:e.target.value})
    }

    handleSelect = (e) => {
        this.setState({page:1, rating:e.target.value})
    }

    searchString = (s) => {
        return s.toLowerCase().includes(this.state.query.toLowerCase())
    }

    handleLanguageSelect = (e) => {
        this.setState({page:1, language:e.target.value})
    }

    searchDetails = (details) => {
        return ((this.searchString(details.title) || this.searchString(details.description)))
    }

    selectDetails = (details) => {
        return ((this.state.rating === details.rating) || (this.state.rating === ""))
    }

    selectLanguageDetails = (details) => {
        return ((this.state.language === details.language) || (this.state.language === ""))
    }

    render() {

        let filteredData =  (
            this.state.data
                .filter(this.selectLanguageDetails)
                .filter(this.selectDetails)
                .filter(this.searchDetails)
        )

        let noOfPages = Math.ceil(filteredData.length/this.state.pageSize)
        if (noOfPages === 0) {noOfPages=1}

        let disabledPrevious = (this.state.page <= 1)
        let disabledNext = (this.state.page >= noOfPages)

        return (
            <div>
                <h1>Films</h1>
                <label>
                    Rating:
                    <select value={this.state.rating} onChange={this.handleSelect}>
                        <option value="">Any</option>
                        <option value="U">U</option>
                        <option value="PG">PG</option>
                        <option value="12">12</option>
                        <option value="15">15</option>
                        <option value="18">18</option>
                    </select>
                </label>
                <label>
                    Language:
                    <select value={this.state.language} onChange={this.handleLanguageSelect}>
                        <option value="">Any</option>
                        <option value="English">English</option>
                        <option value="Italian">Italian</option>
                        <option value="French">French</option>
                        <option value="German">German</option>
                        <option value="Japanese">Japanese</option>
                        <option value="Mandarin">Mandarin</option>
                    </select>
                </label>
                <p>Search: {this.state.query}</p>
                <input
                    type='text'
                    placeholder='search'
                    value={this.state.query}
                    onChange={this.handleSearch}
                />
                {this.state.data
                    .filter(this.selectLanguageDetails)
                    .filter(this.selectDetails)
                    .filter(this.searchDetails)
                    .slice((this.state.page*this.state.pageSize)-this.state.pageSize,(this.state.page*this.state.pageSize))
                    .map( (details,i) => (<Film key={i} details={details} />) )}
                <button onClick={this.handlePreviousClick} disabled={disabledPrevious}>Previous</button>
                Page {this.state.page} of {noOfPages}
                <button onClick={this.handleNextClick} disabled={disabledNext}>Next</button>
            </div>
        );
    }

}

function App() {
    return (
        <div className="App">
            <Films />
        </div>
    );
}

export default App;