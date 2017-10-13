import React, {Component} from 'react';

class ProblemsTable extends Component {
    constructor() {
        super();
        this.props = {problems: []};
    }
    render() {
        const rows = this.props.problems.map(e=> (
            <tr key={e.id}>
                <td>{e.id}</td>
                <td>{e.location_id}</td>
                <td>{e.description}</td>
                <td>{e.date}</td>
                <td>{e.fixed}</td>
            </tr>                                     
        ));
        return (
              <table>
                <tr>
                    <th>ID</th>
                    <th>Location ID</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Fixed</th>
                </tr>
                {rows}
              </table>
        );
    }
}

export default ProblemsTable;