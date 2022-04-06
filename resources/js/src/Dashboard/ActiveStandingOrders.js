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

export default function ActiveStandingOrders(props) {
  const classes = useStyles();
 if(props.user.vendor){
     return (
    <Card title="Active Standing Orders">

      <Table size="small">
        <TableHead>
          <TableRow>
            {/*<TableCell align="right">discount</TableCell>*/}
            <TableCell>name</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>

          {props.user.vendor.activeSos && props.user.vendor.activeSos.data.map((row, id) => {
            return <TableRow key={id}>
              {/*<TableCell align="right">{row.discount * 100}%</TableCell>*/}
              <TableCell>{row.SOSERIES}</TableCell>
              
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
