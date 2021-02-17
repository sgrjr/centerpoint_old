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

export default function Users(props) {
  const classes = useStyles();
 if(props.user.vendor && props.user.vendor.users){
     return (
    <Card title="Manage Users">

      <Table size="small">
        <TableHead>
          <TableRow>
            <TableCell></TableCell>
            <TableCell>Name</TableCell>
            <TableCell align="right">EMAIL</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>

          {props.user.vendor.users && props.user.vendor.users.data.map((row, id) => {
            return <TableRow key={id}>
              <TableCell></TableCell>
              <TableCell>{row.FIRST} {row.LAST}</TableCell>
              <TableCell align="right">{row.EMAIL}</TableCell>
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
