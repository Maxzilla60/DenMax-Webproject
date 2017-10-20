const initialState = {
    title: 'Dashboard',
    calorieEntries: [],
};

const layoutreducer = (state = initialState, action) => {
    switch (action.type) {
        case 'SET_TITLE':
            return { ...state, ...{ title: action.payload } };
        case 'SET_CALORIEENTRIES':
            return { ...state, ...{ calorieEntries: action.payload } };
        case 'ADD_CALORIEENTRY':
            return { ...state, ...{ calorieEntries: [...state.calorieEntries, action.payload] } };
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