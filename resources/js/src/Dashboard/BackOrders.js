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

export default function BackOrders(props) {
  const classes = useStyles();
 if(props.user.vendor){
     return (
    <Card title="Back Orders">

      <Table size="small">
        <TableHead>
          <TableRow>
            <TableCell></TableCell>
            <TableCell>ID</TableCell>
            <TableCell>PO#</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
          {props.user.vendor.back && props.user.vendor.back.data.map((row, id) => {
            return <TableRow key={id}>
              <TableCell><a href={"/dashboard/invoice/" + row.TRANSNO}>view</a></TableCell>
              <TableCell>{row.TRANSNO}</TableCell>
              <TableCell>{row.PO_NUMBER}</TableCell>
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
