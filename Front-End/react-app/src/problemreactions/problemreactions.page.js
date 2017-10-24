import React, { Component } from 'react';

import ProblemreactionsTable from './problemreactions-table';
import TextField from 'material-ui/TextField';
import FloatingActionButton from 'material-ui/FloatingActionButton';
import ContentAdd from 'material-ui/svg-icons/content/add';

import HttpService from '../common/http-service';
import { connect } from "react-redux";

import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';

import { Link } from 'react-router-dom';

let hasFetchedProblemreactions = false;

class ProblemreactionsPage extends Component {
    componentWillMount() {
        if (!hasFetchedProblemreactions) {
            HttpService.getAllProblemreactions().then(fetchedProblemreactions => this.props.setProblemreactions(fetchedProblemreactions));
            hasFetchedProblemreactions = true;
        }
    }
    
    searchByProblem = (evt) => {
        if (evt.target.value != null && evt.target.value != "") {
            HttpService.getProblemreactionsByProblem(evt.target.value).then(fetchedProblemreactions => this.props.setProblemreactions(fetchedProblemreactions));
        }
        else {
            HttpService.getAllProblemreactions().then(fetchedProblemreactions => this.props.setProblemreactions(fetchedProblemreactions));
        }
    }

    render() {
        const fetchedProblemreactions = this.props.problemreactions;
        return (
            <div>
                <TextField type="number" onChange={(evt) => this.searchByProblem(evt)} hintText="Search by Problem ID" style={{width: '100%'}} />
                <ProblemreactionsTable entries={fetchedProblemreactions} />
                <Link to="/problemreactions/add">
                    <FloatingActionButton style={{ position: 'fixed', right: '15px', bottom: '15px' }}>
                        <ContentAdd />
                    </FloatingActionButton>
                </Link>
            </div>
        );
    }
    componentDidMount() {
        this.props.setTitle('Problem Reactions');
    }
}

const mapStateToProps = (state, ownProps) => {
    return {
        problemreactions: state.problemreactions,
    };
};

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        setProblemreactions: (problemreactions) => {
            dispatch({ type: 'SET_PROBLEMREACTIONS', payload: problemreactions });
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ProblemreactionsPage);
