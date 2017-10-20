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
        <TableRowColumn>{props.entry.location_id}</TableRowColumn>
        <TableRowColumn>{props.entry.description}</TableRowColumn>
        <DateRowColumn date={props.entry.date} />
        <FixedRowColumn fixed={props.entry.fixed} />
        <TableRowColumn>{props.entry.technician ? props.entry.technician : "N/A"}</TableRowColumn>
    </TableRow>
)

const FixedRowColumn = (props) => {
    if (props.fixed == 1) {
        return (
            <TableRowColumn style={{backgroundColor: '#28a745'}}>Fixed</TableRowColumn>
        )
    }
    if (props.fixed == 0) {
        return (
            <TableRowColumn style={{backgroundColor: '#dc3545'}}>Not Fixed</TableRowColumn>
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

const ProblemsTable = (props) => (
    <Table>
        <TableHeader displaySelectAll={false}>
            <TableRow>
                <TableHeaderColumn>ID</TableHeaderColumn>
                <TableHeaderColumn>Location</TableHeaderColumn>
                <TableHeaderColumn>Description</TableHeaderColumn>
                <TableHeaderColumn>Date</TableHeaderColumn>
                <TableHeaderColumn>Fixed</TableHeaderColumn>
                <TableHeaderColumn>Technician</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody>
            <Rows entries={props.entries} />
        </TableBody>
    </Table>
)


export default ProblemsTable;
