import React from "react";

class NotFound404 extends React.Component {
    render() {
        return (
            <div className='error'>
                <p>The page you are looking for could not be found. Please check your spelling and ensure you are trying to reach a valid page</p>
                <p>Error: Not Found</p>
                <p>Error Code: 404</p>
            </div>
        )
    }
}

export default NotFound404;