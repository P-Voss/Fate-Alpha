
const defaultAttributes = {
    value: 0,
    category: 'f',
    uber: false,
    changeRange: {
        topValue: 0,
        topCategory: 'f',
        bottomValue: 0,
        bottomCategory: 'f'
    }
};

const initialState = {
    system: {
        fetchPrograms: false,
        calculatePreview: false,
        executingTraining: false,

        fetchAttributes: true,

        errors: []
    },

    remainingDays: 0,
    trainingPrograms: [],
    characterAttributes: {
        'Str': defaultAttributes,
        'Agi': defaultAttributes,
        'End': defaultAttributes,
        'Pra': defaultAttributes,
        'Con': defaultAttributes,
        'Dis': defaultAttributes,
    }
};

export default function trainingApp(state = initialState, action) {
    console.log(action);

    switch (action.type) {
        case 'UPDATE_REMAINING_DAYS':
            return {...state, remainingDays: 12};

        case 'RECEIVE_TRAINING_PROGRAMS':
            return {...state, trainingPrograms: action.programs, fetchPrograms: false};

        case 'FETCH_TRAINING_PROGRAMS':
            return {...state, fetchPrograms: true};

        case 'REQUEST_ATTRIBUTES':
            return {...state, fetchAttributes: true};

        case 'RECEIVE_ATTRIBUTES':
            return {...state, fetchAttributes: false};

        default:
            return state;
    }
};
