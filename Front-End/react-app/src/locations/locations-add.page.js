import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';
import TextField from 'material-ui/TextField';
import FlatButton from 'material-ui/FlatButton';
import HttpService from '../common/http-service';
import { Link } from 'react-router-dom';

class LocationsAddPage extends Component {
    constructor() {
        super();
    }
    render() {
        return (
            <div>
                <form onSubmit={this.save}>
                    <TextField hintText="Name" name="name" type="text" style={{width: '100%'}} /><br/>
                    <TextField hintText="Company ID" name="company_id" type="number" style={{width: '100%'}} /><br/>
                    <FlatButton label="Add" type="submit" style={{width: '100%'}} />
                </form>
            </div>
        );
    }
    save = (ev) => {
        ev.preventDefault();
        const name = ev.target['name'].value;
        const company_id = ev.target['company_id'].value;
        const id = "N/A";
        HttpService.addLocation(name, company_id).then(() => {
            this.props.addLocation({
                "id": id,
                "name": name,
                "company_id": company_id
            });
            window.location = "/locations";
        });
    }
    componentDidMount() {
        this.props.setTitle('Add Location');
    }
}

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        addLocation: (location) => {
            dispatch({ type: 'ADD_LOCATION', payload: location });
        }
    }
}

export default connect(undefined, mapDispatchToProps)(LocationsAddPage)
