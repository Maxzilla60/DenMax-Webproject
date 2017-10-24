import React from 'react';
import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
} from 'material-ui/Table';
import { Link } from 'react-router-dom';

const Row = (props) => (
    <TableRow key={props.entry.id} hoverable={true}>
        <Link to={"/users/edit/" + props.entry.id}><TableRowColumn>{props.entry.id}</TableRowColumn></Link>
        <TableRowColumn>{props.entry.name}</TableRowColumn>
        <RoleRowColumn role={props.entry.role} />
    </TableRow>
)

const RoleRowColumn = (props) => {
    if (props.role == 0) {
        return (<TableRowColumn>Technician</TableRowColumn>)
    }
    else if (props.role == 1) {
        return (<TableRowColumn>WorkManager</TableRowColumn>)
    }
    else {
        return (<TableRowColumn>Admin</TableRowColumn>)
    }
}

const Rows = (props) => props.entries.map(e => (
    <Row entry={e}/>
));

const UsersTable = (props) => (
    <Table>
        <TableHeader displaySelectAll={false}>
            <TableRow>
                <TableHeaderColumn>ID</TableHeaderColumn>
                <TableHeaderColumn>Name</TableHeaderColumn>
                <TableHeaderColumn>Role</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody>
            <Rows entries={props.entries} />
        </TableBody>
    </Table>
)


export default UsersTable;
