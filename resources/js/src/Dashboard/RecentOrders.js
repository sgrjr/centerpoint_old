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

export default function RecentOrders(props) {
  const classes = useStyles();
 if(props.user.vendor){
     return (

    <Card title="Recent Orders">

      <Table size="small">
        <TableHead>
          <TableRow>
            <TableCell>view</TableCell>
            <TableCell>Date</TableCell>
            <TableCell>PO#</TableCell>
            <TableCell align="right">UPS Key</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>

          {props.user.vendor.recent && props.user.vendor.recent.data.map((row, id) => {
            return <TableRow key={id}>
              <TableCell><a href={"/dashboard/invoice/" + row.TRANSNO}>view</a></TableCell>
              <TableCell>{row.DATE}</TableCell>
              <TableCell>{row.PO_NUMBER}</TableCell>
              <TableCell align="right">{row.UPS_KEY}</TableCell>
            </TableRow>
          })}

          {props.user.vendor.old && props.user.vendor.old.data.map((row, id) => {
            return <TableRow key={id}>
              <TableCell><a href={"/dashboard/invoice/" + row.TRANSNO}>view</a></TableCell>
              <TableCell>{row.DATE}</TableCell>
              <TableCell>{row.PO_NUMBER}</TableCell>
              <TableCell align="right">
              <a href={"https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums="+row.UPS_KEY}>{row.UPS_KEY}</a> 
              <a href={"https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums="+row.UPS_KEY_2}>{row.UPS_KEY_2}</a> 
              <a href={"https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums="+row.UPS_KEY_3}>{row.UPS_KEY_3}</a> 
              <a href={"https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums="+row.UPS_KEY_4}>{row.UPS_KEY_4}</a> 
              <a href={"https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums="+row.UPS_KEY_5}>{row.UPS_KEY_5}</a> </TableCell>
            </TableRow>
          })}

          {props.user.vendor.ancient && props.user.vendor.ancient.data.map((row,id) => (
            <TableRow key={id}>
               <TableCell><a href={"/dashboard/invoice/" + row.TRANSNO}>view</a></TableCell>
              <TableCell>{row.DATE}</TableCell>
              <TableCell>{row.PO_NUMBER}</TableCell>
              <TableCell align="right">{row.UPS_KEY}</TableCell>
            </TableRow>
          ))}

        </TableBody>
      </Table>
      <div className={classes.seeMore}>
        <Link color="primary" to="#" onClick={preventDefault}>
          See more orders
        </Link>
      </div>
    </Card>
  );
  }else{
    return <div/>;
  }

 
}
