import React from 'react';
import Link from '@material-ui/core/Link';
import { makeStyles } from '@material-ui/core/styles';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Card from '../components/Card'
import CircularProgress from '@material-ui/core/CircularProgress';

function preventDefault(event) {
  event.preventDefault();
}

const useStyles = makeStyles(theme => ({
  seeMore: {
    marginTop: theme.spacing(3),
  },
}));

export default function ProcessingOrders(props) {
  const classes = useStyles();
 if(props.user.vendor && props.user.vendor.processing && props.user.vendor.processing.data.length >= 1){
     return (
    <Card title="Processing">

      <Table size="small">
        <TableHead>
          <TableRow>
            <TableCell></TableCell>
            <TableCell>Date</TableCell>
            <TableCell>PO#</TableCell>
            <TableCell>TRANSNO</TableCell>
            <TableCell>REMOTEADDR</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>

          {props.user.vendor.processing && props.user.vendor.processing.data.map((row, id) => {
            return <TableRow key={id}>
              <TableCell><a href={"/dashboard/invoice/" + row.REMOTEADDR}>view</a></TableCell>
              <TableCell>{row.DATE}</TableCell>
              <TableCell>{row.PO_NUMBER}</TableCell>
              <TableCell>{row.TRANSNO}</TableCell>
              <TableCell>{row.REMOTEADDR}</TableCell>
            </TableRow>
          })}

        </TableBody>
      </Table>
      <div className={classes.seeMore}>
        <Link color="primary" to="#" onClick={preventDefault}>
          {/*See more orders*/}
        </Link>
      </div>
    </Card>
  );
  }else{
    return <div/>;
  }

 
}
