
import axios from 'axios';

export function updateRemainingDays() {
    return {
        type: "UPDATE_REMAINING_DAYS"
    };
}

export function loadCharacterAttributes(accessKey) {
    return dispatch => {
        dispatch(requestAttributes());
        return axios.get(process.env.REACT_APP_CHARACTER_API_URL + accessKey)
            .then(
                response => {
                    if (response.data.success) {
                        dispatch(receiveAttributes(response.data.attributes));
                    } else {
                        dispatch(errorRequestAttributes());
                    }
                },
                error => console.log(error)
            );
    }
}

function requestAttributes() {
    return {
        type: "REQUEST_ATTRIBUTES"
    };
}

function receiveAttributes(attributes) {
    return {
        type: "RECEIVE_ATTRIBUTES",
        data: attributes
    };
}

function errorRequestAttributes() {
    return {
        type: "ERROR_REQUEST_ATTRIBUTES"
    };
}
