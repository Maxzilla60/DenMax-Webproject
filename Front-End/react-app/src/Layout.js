import React, { Component } from 'react';
import AppBar from 'material-ui/AppBar';
import Drawer from 'material-ui/Drawer';
import MenuItem from 'material-ui/MenuItem';
import {
    BrowserRouter as Router,
    Route,
    Link
} from 'react-router-dom';
import DashboardPage from './dashboard/dashboard.page';
import LocationsPage from './locations/locations.page';
import LocationsAddPage from './locations/locations-add.page';
import StatusreportsPage from './statusreports/statusreports.page';
import StatusreportsAddPage from './statusreports/statusreports-add.page';
import ProblemsPage from './problems/problems.page';
import ProblemsAddPage from './problems/problems-add.page';
import ProblemsTechnicianPage from './problems/problems-tech.page';
import CompaniesPage from './companies/companies.page';
import { connect } from 'react-redux';

class Layout extends Component {
    constructor() {
        super();
        this.state = { drawerOpen: false };
    }
    toggleState = () => {
        const currentState = this.state.drawerOpen;
        this.setState({ drawerOpen: !currentState });
    }
    render() {
        return (
            <Router>
                <div>
                    <AppBar
                        title={this.props.title}
                        onLeftIconButtonTouchTap={this.toggleState}
                    />
                    <Drawer open={this.state.drawerOpen}>
                        <Link to="/"><MenuItem onClick={this.toggleState} >
                            Dashboard
                        </MenuItem></Link>
                        <Link to="/locations"><MenuItem onClick={this.toggleState} >
                            Locations
                        </MenuItem></Link>
                        <Link to="/statusreports"><MenuItem onClick={this.toggleState} >
                            Status Reports
                        </MenuItem></Link>
                        <Link to="/problems"><MenuItem onClick={this.toggleState} >
                            Problems
                        </MenuItem></Link>
                        <Link to="/companies"><MenuItem onClick={this.toggleState} >
                            Companies
                        </MenuItem></Link>
                    </Drawer>
                    <Route exact={true} path="/" component={DashboardPage} />
                    <Route exact={true} path="/locations" component={LocationsPage} />
                    <Route path="/locations/add" component={LocationsAddPage} />
                    <Route exact={true} path="/statusreports" component={StatusreportsPage} />  
                    <Route path="/statusreports/add" component={StatusreportsAddPage} />
                    <Route exact={true} path="/problems" component={ProblemsPage} />
                    <Route path="/problems/add" component={ProblemsAddPage} />
                    <Route path="/problems/technician/:id" component={ProblemsTechnicianPage} />
                    <Route exact={true} path="/companies" component={CompaniesPage} />
                </div>
            </Router>
        );
    }
}

const mapStateToProps = (state, ownProps) => {
    return {
        title: state.title,
    }
}

export default connect(mapStateToProps)(Layout);
