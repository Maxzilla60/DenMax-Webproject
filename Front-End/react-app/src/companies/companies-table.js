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
    </TableRow>
)

const Rows = (props) => props.entries.map(e => (
    <Row entry={e}/>
));

const CompaniesTable = (props) => (
    <Table>
        <TableHeader displaySelectAll={false}>
            <TableRow>
                <TableHeaderColumn>ID</TableHeaderColumn>
                <TableHeaderColumn>Name</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody>
            <Rows entries={props.entries} />
        </TableBody>
    </Table>
)


export default CompaniesTable;
