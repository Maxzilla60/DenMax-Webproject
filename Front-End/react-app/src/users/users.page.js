import React, { Component } from 'react';

import UsersTable from './users-table';
import TextField from 'material-ui/TextField';
import FloatingActionButton from 'material-ui/FloatingActionButton';
import ContentAdd from 'material-ui/svg-icons/content/add';

import HttpService from '../common/http-service';
import { connect } from "react-redux";

import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';

import { Link } from 'react-router-dom';

let hasFetchedUsers = false;

class UsersPage extends Component {
    componentWillMount() {
        if (!hasFetchedUsers) {
            HttpService.getAllUsers().then(fetchedUsers => this.props.setUsers(fetchedUsers));
            hasFetchedUsers = true;
        }
    }
    
    searchByRole = (evt) => {
        if (evt.target.value != null && evt.target.value != "") {
            HttpService.getUsersByRole(evt.target.value).then(fetchedUsers => this.props.setUsers(fetchedUsers));
        }
        else {
            HttpService.getAllUsers().then(fetchedUsers => this.props.setUsers(fetchedUsers));
        }
    }

    render() {
        const fetchedUsers = this.props.users;
        return (
            <div>
                <TextField type="number" onChange={(evt) => this.searchByRole(evt)} hintText="Search by Role" style={{width: '100%'}} />
                <UsersTable entries={fetchedUsers} />
                <Link to="/users/add">
                    <FloatingActionButton style={{ position: 'fixed', right: '15px', bottom: '15px' }}>
                        <ContentAdd />
                    </FloatingActionButton>
                </Link>
            </div>
        );
    }
    componentDidMount() {
        this.props.setTitle('Users');
    }
}

const mapStateToProps = (state, ownProps) => {
    return {
        users: state.users,
    };
};

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        setUsers: (users) => {
            dispatch({ type: 'SET_USERS', payload: users });
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(UsersPage);
