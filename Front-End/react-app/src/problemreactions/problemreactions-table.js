import React from 'react';
import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
} from 'material-ui/Table';

const Row = (props) => (
    <TableRow key={props.entry.id} hoverable={true}>
        <TableRowColumn>{props.entry.id}</TableRowColumn>
        <TableRowColumn>{props.entry.problem_id}</TableRowColumn>
        <RatingRowColumn rating={props.entry.rating} />
        <TableRowColumn>{props.entry.description}</TableRowColumn>
    </TableRow>
)

const RatingRowColumn = (props) => {
    if (props.rating == 1) {
        return (
            <TableRowColumn style={{background: "#28a745"}}>⬆️</TableRowColumn>
        )
    }
    else {
        return (
            <TableRowColumn style={{background: "#dc3545"}}>⬇️</TableRowColumn>
        )
    }
}

const Rows = (props) => props.entries.map(e => (
    <Row entry={e}/>
));

const ProblemreactionsTable = (props) => (
    <Table>
        <TableHeader displaySelectAll={false}>
            <TableRow>
                <TableHeaderColumn>ID</TableHeaderColumn>
                <TableHeaderColumn>Problem</TableHeaderColumn>
                <TableHeaderColumn>Rating</TableHeaderColumn>
                <TableHeaderColumn>Description</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody>
            <Rows entries={props.entries} />
        </TableBody>
    </Table>
)


export default ProblemreactionsTable;
