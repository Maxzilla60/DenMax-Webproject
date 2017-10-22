import React, { Component } from 'react';

import LocationsTable from './locations-table';
import TextField from 'material-ui/TextField';
import FloatingActionButton from 'material-ui/FloatingActionButton';
import ContentAdd from 'material-ui/svg-icons/content/add';

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
        }
    }

    render() {
        const fetchedLocations = this.props.locations;
        return (
            <div>
                <TextField type="number" onChange={(evt) => this.searchByCompany(evt)} hintText="Search by Company ID" style={{width: '100%'}} />
                <LocationsTable entries={fetchedLocations} />
                <Link to="/locations/add">
                    <FloatingActionButton style={{ position: 'fixed', right: '15px', bottom: '15px' }}>
                        <ContentAdd />
                    </FloatingActionButton>
                </Link>
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
