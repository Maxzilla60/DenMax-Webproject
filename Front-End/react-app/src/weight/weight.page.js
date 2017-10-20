import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToProps from '../common/title-dispatch-to-props';

class WeightPage extends Component {
    render() {
        return (
            <h2>Weight</h2>
        )
    }
    componentDidMount() {
        this.props.setTitle('Weight');
    }
}

export default connect(undefined, mapDispatchToProps)(WeightPage);
