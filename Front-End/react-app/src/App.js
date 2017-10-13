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
        //HttpService.getProblemsByLocation(1).then(s => this.setState({problems: s}));
        //HttpService.getStatusReportsByLocation(1).then(s => this.setState({problems: s}));
    }
    
    search = (query) => {
        alert(query);
    }
    
    render() {
        return (
            <div className="App">
                <LocationsTable locations={this.state.locations} />
                <ProblemsTable problems={this.state.problems} />
                <StatusReportsTable statusreports={this.state.statusreports} />
                <LocationSearch onchange={this.search}/>
            </div>
        );
    }
}

export default App;
