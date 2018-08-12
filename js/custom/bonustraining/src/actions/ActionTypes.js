
import axios from 'axios';

export function loadTrainingPrograms(accessKey) {
    return dispatch => {
        dispatch(requestPrograms());
        return axios.get(process.env.REACT_APP_TRAINING_API_URL + accessKey)
            .then(
                response => {
                    if (response.data.success) {
                        dispatch(receivePrograms(response.data.programs));
                    } else {
                        dispatch(errorRequestPrograms());
                    }
                },
                error => console.log(error)
            );

    };
}
function receivePrograms(programs = []) {
    return {
        type: "RECEIVE_TRAINING_PROGRAMS", programs: programs
    };
}
function requestPrograms() {
    return {
        type: 'FETCH_TRAINING_PROGRAMS'
    };
}
function errorRequestPrograms() {

}


export function simulateTraining(trainingProgram, days) {
    return {
        type: "SIMULATE_TRAINING",
        trainingProgram,
        days
    };
}

export function executeTraining(trainingProgram, days) {
    return {
        type: "EXECUTE_TRAINING",
        trainingProgram,
        days
    };
}
