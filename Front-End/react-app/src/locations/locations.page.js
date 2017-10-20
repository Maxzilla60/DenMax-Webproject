import React, { Component } from 'react';

import LocationsTable from './locations-table';
import TextField from 'material-ui/TextField';

import HttpService from '../common/http-service';
import { connect } from "react-redux";

import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';

import { Link } from 'react-router-dom';

let hasFetchedLocations = false;

class LocationsPage extends Component {
    componentWillMount() {
        if (!hasFetchedLocations) {
            HttpService.getAllLocations().then(fetchedLocations => this.props.setLocations(fetchedLocations));
            hasFetchedLocations = true;
        }
    }
    
    searchByCompany = (evt) => {
        if (evt.target.value != null && evt.target.value != "") {
            HttpService.getLocationByCompany(evt.target.value).then(fetchedLocations => this.props.setLocations(fetchedLocations));
        }
        else {
            HttpService.getAllLocations().then(fetchedLocations => this.props.setLocations(fetchedLocations));
            hasFetchedLocations = true;
        }
    }

    render() {
        const fetchedLocations = this.props.locations;
        console.log("Hierzo");
        console.log(fetchedLocations);
        return (
            <div>
                <TextField onChange={(evt) => this.searchByCompany(evt)} hintText="Search by Company ID" style={{width: '100%'}} />
                <LocationsTable entries={this.props.locations} />
            </div>
        );
    }
    componentDidMount() {
        this.props.setTitle('Locations');
    }
}

const mapStateToProps = (state, ownProps) => {
    return {
        locations: state.locations,
    };
};

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        setLocations: (locations) => {
            dispatch({ type: 'SET_LOCATIONS', payload: locations });
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(LocationsPage);
