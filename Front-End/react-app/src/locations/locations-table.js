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
        <TableRowColumn>{props.entry.name}</TableRowColumn>
        <TableRowColumn>{props.entry.company_id ? props.entry.company_id : "N/A"}</TableRowColumn>
    </TableRow>
)

const Rows = (props) => props.entries.map(e => (
    <Row entry={e}/>
));

const LocationsTable = (props) => (
    <Table>
        <TableHeader displaySelectAll={false}>
            <TableRow>
                <TableHeaderColumn>ID</TableHeaderColumn>
                <TableHeaderColumn>Name</TableHeaderColumn>
                <TableHeaderColumn>Company</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody>
            <Rows entries={props.entries} />
        </TableBody>
    </Table>
)


export default LocationsTable;
