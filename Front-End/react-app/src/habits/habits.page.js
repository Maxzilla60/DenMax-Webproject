import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToProps from '../common/title-dispatch-to-props';

class HabitsPage extends Component {
    render(){
        return (
            <h2>Habits</h2>
        )
    }
    componentDidMount() {
        this.props.setTitle('Habits');
    }    
}

export default connect(undefined, mapDispatchToProps)(HabitsPage);
