import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';
import TextField from 'material-ui/TextField';
import FlatButton from 'material-ui/FlatButton';
import HttpService from '../common/http-service';
import { Link } from 'react-router-dom';

class ProblemreactionsAddPage extends Component {
    constructor() {
        super();
    }
    render() {
        return (
            <div>
                <form onSubmit={this.save}>
                    <TextField hintText="Problem ID" name="problem_id" type="number" style={{width: '100%'}} required /><br/>
                    <TextField hintText="Rating" name="rating" type="number" min="0" max="1" style={{width: '100%'}} required /><br/>
                    <TextField hintText="Description" name="description" type="text" style={{width: '100%'}} /><br/>
                    <FlatButton label="Add" type="submit" style={{width: '100%'}} />
                </form>
            </div>
        );
    }
    save = (ev) => {
        ev.preventDefault();
        const problem_id = ev.target['problem_id'].value;
        const rating = ev.target['rating'].value;
        const description = ev.target['description'].value;
        const id = "N/A";
        HttpService.addProblemreaction(problem_id, rating, description).then(() => {
            this.props.addProblemreaction({
                "id": id,
                "problem_id": problem_id,
                "rating": rating,
                "description": description
            });
            window.location = "/problemreactions";
        });
    }
    componentDidMount() {
        this.props.setTitle('Add Problem Reaction');
    }
}

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        addProblemreaction: (problemreaction) => {
            dispatch({ type: 'ADD_PROBLEMREACTION', payload: problemreaction });
        }
    }
}

export default connect(undefined, mapDispatchToProps)(ProblemreactionsAddPage)
