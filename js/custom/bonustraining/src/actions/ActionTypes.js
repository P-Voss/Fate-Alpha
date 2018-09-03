
import axios from 'axios';
import {loadCharacterAttributes} from './CharacterActionTypes'

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
                error => {}
            );

    };
}

export function executeTraining(trainingProgram, days, accessKey) {
    return dispatch => {
        dispatch(requestExecuteTraining());

        const data = new FormData();
        data.append('program', trainingProgram);
        data.append('days', days);
        data.append('accessKey', accessKey);
        return axios.post(
                process.env.REACT_APP_EXEC_TRAINING_API_URL,
                data,
                {headers: {'Content-Type': 'application/x-www-form-urlencoded'}}
            )
            .then(
                response => {
                    if (response.data.success) {
                        dispatch(loadCharacterAttributes(accessKey));
                    } else {
                        dispatch(errorExecuteTraining());
                    }
                },
                error => {}
            );

    };
}

function receivePrograms(programs = []) {
    return {
        type: "RECEIVE_TRAINING_PROGRAMS",
        programs: programs
    };
}

function requestPrograms() {
    return {
        type: 'FETCH_TRAINING_PROGRAMS'
    };
}

function errorRequestPrograms() {

}

function requestExecuteTraining() {
    return {
        type: 'REQUEST_EXECUTE_TRAINING'
    };
}

function errorExecuteTraining() {
    return {
        type: 'ERROR_TRAINING'
    };
}


export function simulateTraining(trainingProgram, days) {
    return {
        type: "SIMULATE_TRAINING",
        trainingProgram,
        days
    };
}
