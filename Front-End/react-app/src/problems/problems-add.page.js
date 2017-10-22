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

class ProblemsAddPage extends Component {
    constructor() {
        super();
        this.state = {statusValue: 0};
    }
    
    render() {
        return (
            <div>
                <form onSubmit={this.save}>
                    <TextField hintText="Location ID" name="location_id" type="number" style={{width: '100%'}} /><br/>
                    <TextField hintText="Description" name="description" type="text" style={{width: '100%'}} /><br/>
                    <FlatButton label="Add" type="submit" style={{width: '100%'}} />
                </form>
            </div>
        );
    }
    save = (ev) => {
        ev.preventDefault();
        const momentDate = moment();
        const date = momentDate.format('YYYY-MM-DD kk:mm:ss');
        const location_id = ev.target['location_id'].value;
        const description = ev.target['description'].value;
        const id = "N/A";
        console.log("Hierzo:");
        console.log(date);
        HttpService.addProblem(description, date, '0', location_id).then(() => {
            this.props.addStatusreport({
                "id": id,
                "date": date,
                "location_id": location_id,
                "description": description,
                "fixed": '0'
            });
            window.location = "/problems";
        });
    }
    componentDidMount() {
        this.props.setTitle('Add Status Report');
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

export default connect(undefined, mapDispatchToProps)(ProblemsAddPage)
