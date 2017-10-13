import React, { Component } from 'react';
import './App.css';
import HttpService from './service';
import LocationsTable from './LocationsTable';
import ProblemsTable from './ProblemsTable';

class App extends Component {
    constructor() {
        super();
        this.state = {locations: [], problems: []};
    }
    
    componentWillMount() {
        //HttpService.getAllLocations().then(s => this.setState({locations : s}));
        //HttpService.getProblemsByLocation(1).then(s => this.setState({problems: s}));
    }
    
    render() {
        return (
            <div className="App">
                <ProblemsTable problems={this.state.problems} />
            </div>
        );
    }
}

export default App;
