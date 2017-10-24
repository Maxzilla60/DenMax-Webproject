import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';
import DatePicker from 'material-ui/DatePicker';
import TextField from 'material-ui/TextField';
import DropDownMenu from 'material-ui/DropDownMenu';
import MenuItem from 'material-ui/MenuItem';
import FlatButton from 'material-ui/FlatButton';
import HttpService from '../common/http-service';
import { Link } from 'react-router-dom';
import moment from 'moment';

class UsersEditPage extends Component {
    constructor() {
        super();
        this.state = {roleValue: 0};
    }
    
    handleChange = (event, index, roleValue) => this.setState({roleValue});
    
    render() {
        return (
            <div>
                <form onSubmit={this.save}>
                    <TextField hintText="Name" name="name" type="text" style={{width: '100%'}} /><br/>
                    <DropDownMenu name="status" value={this.state.roleValue} onChange={this.handleChange} style={{width: '100%'}}>
                      <MenuItem value={0} primaryText="Technician" />
                      <MenuItem value={1} primaryText="WorkManager" />
                      <MenuItem value={2} primaryText="Admin" />
                    </DropDownMenu>
                    <FlatButton label="Set" type="submit" style={{width: '100%'}} />
                    <FlatButton label="Delete" onClick={() => this.deleteUser(this.props.match.params.id)} style={{width: '100%'}} />
                </form>
            </div>
        );
    }
    
    deleteUser = (id) => {
        HttpService.deleteUser(id);
        window.location = "/users";
    }
    
    save = (ev) => {
        ev.preventDefault();
        const name = ev.target['name'].value;
        const role = this.state.roleValue;
        const id = this.props.match.params.id;
        HttpService.updateUser(id, name, role).then(() => {
            window.location = "/users";
        });
    }
    componentDidMount() {
        this.props.setTitle('Edit User (' + this.props.match.params.id + ')' );
    }
}

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        addUser: (user) => {
            dispatch({ type: 'ADD_USER', payload: user });
        }
    }
}

export default connect(undefined, mapDispatchToProps)(UsersEditPage)
