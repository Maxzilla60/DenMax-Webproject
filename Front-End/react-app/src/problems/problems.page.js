import React, { Component } from 'react';

import ProblemsTable from './problems-table';
import TextField from 'material-ui/TextField';
import FloatingActionButton from 'material-ui/FloatingActionButton';
import ContentAdd from 'material-ui/svg-icons/content/add';

import HttpService from '../common/http-service';
import { connect } from "react-redux";

import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';

import { Link } from 'react-router-dom';

let hasFetchedProblems = false;

class ProblemsPage extends Component {
    componentWillMount() {
        if (!hasFetchedProblems) {
            HttpService.getAllProblems().then(fetchedProblems => this.props.setProblems(fetchedProblems));
            hasFetchedProblems = true;
        }
    }
    
    searchByLocation = (evt) => {
        if (evt.target.value != null && evt.target.value != "") {
            HttpService.getProblemByLocation(evt.target.value).then(fetchedProblems => this.props.setProblems(fetchedProblems));
        }
        else {
            HttpService.getAllProblems().then(fetchedProblems => this.props.setProblems(fetchedProblems));
        }
    }

    render() {
        const fetchedProblems = this.props.problems;
        return (
            <div>
                <TextField type="number" onChange={(evt) => this.searchByLocation(evt)} hintText="Search by Location ID" style={{width: '100%'}} />
                <ProblemsTable entries={fetchedProblems} />
                <Link to="/problems/add">
                    <FloatingActionButton style={{ position: 'fixed', right: '15px', bottom: '15px' }}>
                        <ContentAdd />
                    </FloatingActionButton>
                </Link>
            </div>
        );
    }
    componentDidMount() {
        this.props.setTitle('Problems');
    }
}

const mapStateToProps = (state, ownProps) => {
    return {
        problems: state.problems,
    };
};

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        setProblems: (problems) => {
            dispatch({ type: 'SET_PROBLEMS', payload: problems });
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ProblemsPage);
