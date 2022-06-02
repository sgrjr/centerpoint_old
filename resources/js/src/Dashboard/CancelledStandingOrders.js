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

export default function CancelledStandingOrders(props) {
  const classes = useStyles();
 if(props.user.vendor && props.user.vendor.inactiveSo && props.user.vendor.inactiveSos.data.length >= 1){
     return (
    <Card title="Cancelled Standing Orders">

      <Table size="small">
        <TableHead>
          <TableRow>
            <TableCell>Name</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>

          {props.user.vendor.inactiveSos && props.user.vendor.inactiveSos.data.map((row, id) => {
            return <TableRow key={id}>
              <TableCell>{row.SOSERIES}</TableCell>
            </TableRow>
          })}

        </TableBody>
      </Table>
    </Card>
  );
  }else{
    return <div/>;
  }

 
}
