import React, { Component } from 'react';

import CompaniesTable from './companies-table';
import TextField from 'material-ui/TextField';

import HttpService from '../common/http-service';
import { connect } from "react-redux";

import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';

import { Link } from 'react-router-dom';

let hasFetchedCompanies = false;

class CompaniesPage extends Component {
    componentWillMount() {
        if (!hasFetchedCompanies) {
            HttpService.getAllCompanies().then(fetchedCompanies => this.props.setCompanies(fetchedCompanies));
            hasFetchedCompanies = true;
        }
    }
    
    searchByUser = (evt) => {
        if (evt.target.value != null && evt.target.value != "") {
            HttpService.getCompanyByUser(evt.target.value).then(fetchedCompanies => this.props.setCompanies(fetchedCompanies));
        }
        else {
            HttpService.getAllCompanies().then(fetchedCompanies => this.props.setCompanies(fetchedCompanies));
        }
    }

    render() {
        const fetchedCompanies = this.props.companies;
        console.log("Hierzo");
        console.log(fetchedCompanies);
        return (
            <div>
                <TextField type="number" onChange={(evt) => this.searchByUser(evt)} hintText="Search by User ID" style={{width: '100%'}} />
                <CompaniesTable entries={fetchedCompanies} />
            </div>
        );
    }
    componentDidMount() {
        this.props.setTitle('Companies');
    }
}

const mapStateToProps = (state, ownProps) => {
    return {
        companies: state.companies,
    };
};

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        setCompanies: (companies) => {
            dispatch({ type: 'SET_COMPANIES', payload: companies });
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(CompaniesPage);
