import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToProps from '../common/title-dispatch-to-props';

class SettingsPage extends Component {
    render(){
        return (
            <h2>Settings</h2>
        )
    }
    componentDidMount() {
        this.props.setTitle('Settings');
    }    
}

export default connect(undefined, mapDispatchToProps)(SettingsPage);
