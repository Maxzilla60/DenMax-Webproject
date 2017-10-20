import React, { Component } from 'react';
import LocationsTable from './locations-table';
import HttpService from '../common/http-service';
import { connect } from "react-redux";
import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';
import FloatingActionButton from 'material-ui/FloatingActionButton';
import ContentAdd from 'material-ui/svg-icons/content/add';
import { Link } from 'react-router-dom';

let hasFetchedLocations = false;

class LocationsPage extends Component {
    componentWillMount() {
        if (!hasFetchedLocations) {
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
