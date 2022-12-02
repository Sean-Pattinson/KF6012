import React from 'react';

/**
 * A text input for searching using a string
 *
 * @props query : string to search for.
 *
 * @author Sean Pattinson
 */

class Search extends React.Component {
    render() {
        return (
            <div>
                <p>Search: {this.props.query}
                    <input
                        type='text'
                        placeholder='search'
                        value={this.props.query}
                        onChange={this.props.handleSearch}
                    />
                </p>

            </div>
        )
    }
}

export default Search;