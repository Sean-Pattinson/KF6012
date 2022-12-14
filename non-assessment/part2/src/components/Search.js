import React from 'react';

/**
 * A text input for searching using a string
 *
 * @props query : string to search for.
 *
 * @author John Rooksby
 */

class Search extends React.Component {
    render() {
        return (
            <div>
                <p>Search: {this.props.query}</p>
                <input
                    type='text'
                    placeholder='search'
                    value={this.props.query}
                    onChange={this.props.handleSearch}
                />
            </div>
        )
    }
}

export default Search;