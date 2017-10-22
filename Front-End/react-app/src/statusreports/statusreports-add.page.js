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

class StatusreportsAddPage extends Component {
    constructor() {
        super();
        this.state = {statusValue: 0};
    }
    
    handleChange = (event, index, statusValue) => this.setState({statusValue});
    
    render() {
        return (
            <div>
                <form onSubmit={this.save}>
                    <TextField hintText="Location ID" name="location_id" type="number" style={{width: '100%'}} /><br/>
                    <DropDownMenu name="status" value={this.state.statusValue} onChange={this.handleChange} style={{width: '100%'}}>
                      <MenuItem value={0} primaryText="Good" />
                      <MenuItem value={1} primaryText="Average" />
                      <MenuItem value={2} primaryText="Bad" />
                    </DropDownMenu>
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
        const status = this.state.statusValue;
        const id = "N/A";
        console.log("Hierzo:");
        console.log(date);
        HttpService.addStatusReport(date, location_id, status).then(() => {
            this.props.addStatusreport({
                "id": id,
                "date": date,
                "location_id": location_id,
                "status": status
            });
            window.location = "/statusreports";
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
            dispatch({ type: 'ADD_STATUSREPORT', payload: location });
        }
    }
}

export default connect(undefined, mapDispatchToProps)(StatusreportsAddPage)
