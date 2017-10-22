const initialState = {
    title: 'Dashboard',
    locations: [],
    statusreports: [],
    problems: []
};

const layoutreducer = (state = initialState, action) => {
    switch (action.type) {
        case 'SET_TITLE':
            return { ...state, ...{ title: action.payload } };
        case 'SET_LOCATIONS':
            return { ...state, ...{ locations: action.payload } };
        case 'SET_STATUSREPORTS':
            return { ...state, ...{ statusreports: action.payload } };
        case 'SET_PROBLEMS':
            return { ...state, ...{ problems: action.payload } };
        case 'ADD_LOCATION':
            return { ...state, ...{ locations: [...state.locations, action.payload] } };
        case 'ADD_STATUSREPORT':
            return { ...state, ...{ statusreports: [...state.statusreports, action.payload] } };
        case 'ADD_PROBLEM':
            return { ...state, ...{ problems: [...state.problems, action.payload] } };
            
        case 'DELETE_CALORIEENTRY':
            const date = action.payload;
            const entryToDeleteIndex = state.calorieEntries.findIndex(e => e.date === date);
            const calorieEntries = [...state.calorieEntries.slice(0, entryToDeleteIndex), ...state.calorieEntries.slice(entryToDeleteIndex + 1)];
            return { ...state, ...{ calorieEntries: calorieEntries } };
        default:
            return state;
    }
}

export default layoutreducer;