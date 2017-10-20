const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        setTitle: (title) => {
            dispatch({ type: 'SET_TITLE', payload: title });
        }
    }
}
export default mapDispatchToProps;
