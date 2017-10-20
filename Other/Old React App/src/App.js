import React, { Component } from 'react';
import './App.css';
import HttpService from './service';
import LocationsTable from './LocationsTable';
import ProblemsTable from './ProblemsTable';
import StatusReportsTable from './StatusReportsTable';
import LocationSearch from './LocationSearch';

class App extends Component {
    constructor() {
        super();
        this.state = {
            locations: [],
            problems: [],
            statusreports: [],
            query: ""
        };
    }
    
    componentWillMount() {
        HttpService.getAllLocations().then(s => this.setState({locations : s}));
        HttpService.getProblemsByLocation(1).then(s => this.setState({problems: s}));
        HttpService.getStatusReportsByLocation(1).then(s => this.setState({problems: s}));
    }
    
    search = (evt) => {
        //console.log(evt.target.value);
        HttpService.getLocationByCompany(evt.target.value).then(s => this.setState({locations : s}));
    }
    
    render() {
        return (
            <div className="App">
                <LocationsTable locations={this.state.locations} />
                <ProblemsTable problems={this.state.problems} />
                <StatusReportsTable statusreports={this.state.statusreports} />
                <input type="text" onChange={(evt) => this.search(evt)} /> 
            </div>
        );
    }
}

export default App;
