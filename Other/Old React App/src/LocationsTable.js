import React, {Component} from 'react';

class LocationsTable extends Component {
    constructor() {
        super();
        this.props = {locations: []};
    }
    render() {
        const rows = this.props.locations.map(e=> (
            <tr key={e.id}>
                <td>{e.id}</td>
                <td>{e.name}</td>
            </tr>                                     
        ));
        return (
              <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
                {rows}
              </table>
        );
    }
}

export default LocationsTable;