import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToProps from '../common/title-dispatch-to-props';

class DashboardPage extends Component {
    render(){
        return (
            <h2>Dashboard</h2>
        )
    }
    componentDidMount() {
        this.props.setTitle('Dashboard');
    }    
}

export default connect(undefined, mapDispatchToProps)(DashboardPage);
