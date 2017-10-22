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

class ProblemsTechnicianPage extends Component {
    constructor() {
        super();
        this.state = {statusValue: 0};
    }
    
    render() {
        return (
            <div>
                <form onSubmit={this.save}>
                    <TextField hintText="Technician ID" name="technician_id" type="number" style={{width: '100%'}} required /><br/>
                    <FlatButton label="Set" type="submit" style={{width: '100%'}} />
                    <FlatButton label="Delete" onClick={() => this.deleteTechnician(this.props.match.params.id)} style={{width: '100%'}} />
                </form>
            </div>
        );
    }
    
    deleteTechnician = (id) => {
        HttpService.deleteTechnician(id);
        window.location = "/problems";
    }
    
    save = (ev) => {
        ev.preventDefault();
        const technician = ev.target['technician_id'].value;
        const id = this.props.match.params.id;
        HttpService.updateTechnician(id, technician).then(() => {
            window.location = "/problems";
        });
    }
    componentDidMount() {
        this.props.setTitle('Edit Technician (' + this.props.match.params.id + ')' );
    }
}

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        addStatusreport: (location) => {
            dispatch({ type: 'ADD_PROBLEM', payload: location });
        }
    }
}

export default connect(undefined, mapDispatchToProps)(ProblemsTechnicianPage)
