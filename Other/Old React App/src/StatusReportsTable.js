import React, {Component} from 'react';

class StatusReportsTable extends Component {
    constructor() {
        super();
        this.props = {statusreports: []};
    }
    render() {
        const rows = this.props.statusreports.map(e=> (
            <tr key={e.id}>
                <td>{e.id}</td>
                <td>{e.location_id}</td>
                <td>{e.status}</td>
                <td>{e.date}</td>
            </tr>             
        ));
        return (
              <table>
                <tr>
                    <th>ID</th>
                    <th>Location ID</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
                {rows}
              </table>
        );
    }
}

export default StatusReportsTable;