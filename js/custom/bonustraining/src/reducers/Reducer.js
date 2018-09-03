
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

    switch (action.type) {
        case 'RECEIVE_TRAINING_PROGRAMS':
            return {...state, trainingPrograms: action.programs, fetchPrograms: false};

        case 'FETCH_TRAINING_PROGRAMS':
            return {...state, fetchPrograms: true};

        case 'REQUEST_ATTRIBUTES':
            return {...state, fetchAttributes: true};

        case 'RECEIVE_ATTRIBUTES':
            let attributes = {
                Str: {...defaultAttributes, value: action.data.strength.value, category: action.data.strength.category},
                Agi: {...defaultAttributes, value: action.data.agility.value, category: action.data.agility.category},
                End: {...defaultAttributes, value: action.data.endurance.value, category: action.data.endurance.category},
                Pra: {...defaultAttributes, value: action.data.practice.value, category: action.data.practice.category},
                Con: {...defaultAttributes, value: action.data.controle.value, category: action.data.controle.category},
                Dis: {...defaultAttributes, value: action.data.discipline.value, category: action.data.discipline.category},
            }
            return {...state, remainingDays: action.data.remainingDays, characterAttributes: attributes};

        default:
            return state;
    }
};
