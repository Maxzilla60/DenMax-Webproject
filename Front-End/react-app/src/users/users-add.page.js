import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';
import TextField from 'material-ui/TextField';
import DropDownMenu from 'material-ui/DropDownMenu';
import MenuItem from 'material-ui/MenuItem';
import FlatButton from 'material-ui/FlatButton';
import HttpService from '../common/http-service';
import { Link } from 'react-router-dom';

class UsersAddPage extends Component {
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
                    <FlatButton label="Add" type="submit" style={{width: '100%'}} />
                </form>
            </div>
        );
    }
    save = (ev) => {
        ev.preventDefault();
        const name = ev.target['name'].value;
        const role = this.state.roleValue;
        const id = "N/A";
        HttpService.addUser(name, role).then(() => {
            this.props.addUser({
                "id": id,
                "name": name,
                "role": role
            });
            window.location = "/users";
        });
    }
    componentDidMount() {
        this.props.setTitle('Add User');
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

export default connect(undefined, mapDispatchToProps)(UsersAddPage)
