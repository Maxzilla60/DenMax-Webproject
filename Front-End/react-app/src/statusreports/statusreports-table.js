import React from 'react';
import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
} from 'material-ui/Table';
import moment from 'moment';

const Row = (props) => (
    <TableRow key={props.entry.id} hoverable={true}>
        <TableRowColumn>{props.entry.id}</TableRowColumn>
        <StatusRowColumn status={props.entry.status} />
        <TableRowColumn>{props.entry.location_id ? props.entry.location_id : "N/A"}</TableRowColumn>
        <DateRowColumn date={props.entry.date} />
    </TableRow>
)

const StatusRowColumn = (props) => {
    if (props.status == 0) {
        return (
            <TableRowColumn style={{backgroundColor: '#28a745'}}>Good</TableRowColumn>
        )
    }
    if (props.status == 1) {
        return (
            <TableRowColumn style={{backgroundColor: '#ffc107'}}>Avarage</TableRowColumn>
        )
    }
    if (props.status == 2) {
        return (
            <TableRowColumn style={{backgroundColor: '#dc3545'}}>Bad</TableRowColumn>
        )
    }
}

const DateRowColumn = (props) => {
    const momentDate = moment(props.date);
    const formattedDate = momentDate.format('MMM Do YY, h:mm:ss a');
    
    return (
        <TableRowColumn>{formattedDate}</TableRowColumn>
    )
}

const Rows = (props) => props.entries.map(e => (
    <Row entry={e}/>
));

const StatusreportsTable = (props) => (
    <Table>
        <TableHeader displaySelectAll={false}>
            <TableRow>
                <TableHeaderColumn>ID</TableHeaderColumn>
                <TableHeaderColumn>Status</TableHeaderColumn>
                <TableHeaderColumn>Location</TableHeaderColumn>
                <TableHeaderColumn>Date</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody>
            <Rows entries={props.entries} />
        </TableBody>
    </Table>
)


export default StatusreportsTable;
