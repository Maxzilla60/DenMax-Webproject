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
import CaloriesPage from './calories/calories.page';
import CaloriesAddPage from './calories/calories-add.page';
import HabitsPage from './habits/habits.page';
import SettingsPage from './settings/settings.page';
import WeightPage from './weight/weight.page';
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
                        <MenuItem onClick={this.toggleState} >
                            <Link to="/">Dashboard</Link>
                        </MenuItem>
                        <MenuItem onClick={this.toggleState} >
                            <Link to="/weight">Weight</Link>
                        </MenuItem>
                        <MenuItem onClick={this.toggleState} >
                            <Link to="/calories">Calories</Link>
                        </MenuItem>
                        <MenuItem onClick={this.toggleState} containerElement={
                            <Link to="/habits"></Link>
                        }>
                            Habits
                        </MenuItem>
                        <MenuItem onClick={this.toggleState} >
                            <Link to="/settings">Settings</Link>
                        </MenuItem>
                    </Drawer>
                    <Route exact={true} path="/" component={DashboardPage} />
                    <Route exact={true} path="/calories" component={CaloriesPage} />
                    <Route path="/calories/add" component={CaloriesAddPage} />
                    <Route path="/habits" component={HabitsPage} />
                    <Route path="/settings" component={SettingsPage} />
                    <Route path="/weight" component={WeightPage} />
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
