import React, { Component } from 'react';
import { connect } from "react-redux";
import mapDispatchToPropsTitle from '../common/title-dispatch-to-props';
import TextField from 'material-ui/TextField';
import DatePicker from 'material-ui/DatePicker';
import FlatButton from 'material-ui/FlatButton';
import HttpService from '../common/http-service';
import { Link } from 'react-router-dom';
import moment from 'moment';

class CaloriesAddPage extends Component {
    constructor() {
        super();
        this.state = { showMessage: false };
    }
    render() {
        const message = (
            <div>
                <span>Entry toegevoegd, klik <Link to='/calories'>hier</Link> om terug te gaan.</span>
            </div>
        );
        return (
            <div>
                <form onSubmit={this.save}>
                    <DatePicker hintText="Date" name="date" />
                    <TextField hintText="calories" name="calories" type="number" />
                    <FlatButton label="Default" type="submit" />
                </form>
                {this.state.showMessage ? message : null}
            </div>
        );
    }
    save = (ev) => {
        ev.preventDefault();
        const date = ev.target['date'].value;
        const calories = ev.target['calories'].value;
        // date in juiste formaat YYYY-MM-dd => ddMMYYYY
        const momentDate = moment(date);
        const dateToSend = momentDate.format('DDMMYYYY');
        const id = HttpService.getId();
        HttpService.addCalorieEntry(dateToSend, calories, id).then(() => {
            this.props.addEntry({
                "id": id,
                "userId": 1,
                "date": dateToSend,
                "weight": calories
            });
            this.setState({ showMessage: true });
        });
    }
    componentDidMount() {
        this.props.setTitle('Update Calorie Intake');
    }
}

const mapDispatchToProps = (dispatch, ownProps) => {
    return {
        ...mapDispatchToPropsTitle(dispatch, ownProps),
        addEntry: (entry) => {
            dispatch({ type: 'ADD_CALORIEENTRY', payload: entry });
        }
    }
}

export default connect(undefined, mapDispatchToProps)(CaloriesAddPage)
