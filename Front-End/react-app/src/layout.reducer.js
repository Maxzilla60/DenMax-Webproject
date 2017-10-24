const initialState = {
    title: 'Dashboard',
    locations: [],
    statusreports: [],
    problems: [],
    companies: [],
    problemreactions: [],
    users: []
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
        case 'SET_PROBLEMREACTIONS':
            return { ...state, ...{ problemreactions: action.payload } };
        case 'SET_USERS':
            return { ...state, ... { users: action.payload } };
        case 'SET_COMPANIES':
            return { ...state, ...{ companies: action.payload } };
        case 'ADD_LOCATION':
            return { ...state, ...{ locations: [...state.locations, action.payload] } };
        case 'ADD_STATUSREPORT':
            return { ...state, ...{ statusreports: [...state.statusreports, action.payload] } };
        case 'ADD_PROBLEM':
            return { ...state, ...{ problems: [...state.problems, action.payload] } };
        case 'ADD_PROBLEMREACTION':
            return { ...state, ...{ problemreactions: [...state.problemreactions, action.payload] } };
        case 'ADD_USER':
            return { ...state, ...{ users: [...state.users, action.payload] } };
        default:
            return state;
    }
}

export default layoutreducer;