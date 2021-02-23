import React from 'react'
import Divider from '@material-ui/core/Divider'
import Table from '@material-ui/core/Table'
import TableBody from '@material-ui/core/TableBody'
import TableCell from '@material-ui/core/TableCell'
import TableHead from '@material-ui/core/TableHead'
import TableRow from '@material-ui/core/TableRow'
import Typography from '@material-ui/core/Typography'
import { makeStyles } from '@material-ui/core/styles'
import grey from '@material-ui/core/colors/grey'

const colorAccent = grey[600]
const useStyles = makeStyles({
  container: {
    display: 'flex',
    flexDirection: 'column',
    width: '100%'
  },
  author: {
    fontSize: '.7rem',
    color: colorAccent
  },
  title: {
    fontSize: '.8rem',
    fontWeight: 'bold'
  },
  info: {
    display: 'grid',
    gridTemplateColumns: 'max-content max-content',
    gridColumnGap: '.5rem',
    gridRowGap: '.25rem',
    textAlign: 'right',
    margin: '16px 16px 16px auto',
    '& p': {
      fontSize: '0.875rem'
    }
  },
  bold: {
    fontWeight: 'bold'
  },
  divider: {
    gridColumn: 'span 2'
  }
})

function OrderSummary(props) {
  const classes = useStyles()
  const cart = {...props.data }
  const invoice = {...cart.invoice }

  let shipping = <Typography>${invoice.totaling.shipping.toFixed(2)}</Typography>
  let items = 0

  cart.items.map(function(i){
    items += i.REQUESTED
  })

  if(items <= 5 && cart.TRANSNO === null){
    shipping = <Typography>NOT CALCULATED</Typography>
  }

  return (
    <div className={classes.container + " " + props.className}>
      <Table>
        <TableHead>
          <TableRow>
            <TableCell></TableCell>
            <TableCell>Title</TableCell>
            <TableCell>ISBN</TableCell>
            <TableCell>Qty.</TableCell>
            <TableCell >Price</TableCell>
            <TableCell >Total</TableCell>
          </TableRow>
        </TableHead>
        <TableBody>
        	{cart.items.map((item, index) => (
            <TableRow key={ index }>
            <TableCell displayPrint="none"><a href={item.url} target="_blank" rel="noopener noreferrer"><img  className="noPrint" style={{width:"75px"}} src={item.coverArt}/></a></TableCell>

              <TableCell component="th" scope="row">
                <Typography className={classes.title}>{item.TITLE}</Typography>
                <Typography className={classes.author}>By {item.AUTHOR}</Typography>
              </TableCell>
              <TableCell>{item.PROD_NO}</TableCell>
              <TableCell>{item.REQUESTED}</TableCell>
              <TableCell align="right">${item.SALEPRICE}</TableCell>
              <TableCell align="right">${(item.REQUESTED * item.SALEPRICE).toFixed(2)}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
      <div className={classes.info}>
        <Typography>Sub-Total: </Typography>
        <Typography>${invoice.totaling.subtotal.toFixed(2)}</Typography>
        <Typography>Shipping: </Typography>
        {shipping}
        <Typography>Paid: </Typography>
        <Typography>${invoice.totaling.paid.toFixed(2)}</Typography>
        <Divider className={classes.divider} />
        <Typography className={classes.bold}>Total: </Typography>
        <Typography className={classes.bold}>${invoice.totaling.grandtotal.toFixed(2)}</Typography>
      </div>
    </div>
  )
}

export default OrderSummary