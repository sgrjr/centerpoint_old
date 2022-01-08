import React from 'react'
import Button from '@mui/material/Button';
import MuiLink from '@mui/material/Link'
import Typography from '@mui/material/Typography';
import IconPicker from '../components/IconPicker';
import { withStyles } from '@mui/styles'
import {Navigate, Link } from 'react-router-dom';

const useStyles =  (theme => ({
  footer: {
    display: 'grid',
    gridTemplateColumns: '1fr auto',
    gridGap: '8px',
    padding: '8px 24px',
    alignItems: 'center'
  },
  incentive: {
    gridColumn: 'span 2',
    fontSize: '.8rem',
    textAlign: 'right'
  },
  total: {
    fontSize: '1rem'
  }
}))

let incentiveText = (quantity, goal) => {
  if (quantity < goal) {
    return `Add ${goal - quantity} more books to get free shipping!`
  } else {
    return 'You qualify for free shipping!'
  }
}

class CartItem extends React.Component {

  render(){

  const props = this.props
  const { classes } = props;   
  const linkStyle = {
    width:"100%",
    height:"100%",
    color:"inherit"
  } 
  return (
    <footer className={classes.footer}>

      <Button variant="contained" color="primary" endIcon={<IconPicker name="chevronRight" disabled={props.quantity > 0 ? false : true}/>} ><Link to={'/dashboard/cart/' + props.cart.REMOTEADDR} style={linkStyle}>Check out</Link></Button>      
      
      <Typography className={classes.total}>Cart total: <strong>${props.price.toFixed(2)}</strong></Typography>
      
      <Button
        variant="contained"
        color="error"
        endIcon={<IconPicker name="delete" />}
        onClick={()=>{
          props.deleteCart({id:props.cart.id})
        }}
      >delete cart</Button>

      <Typography className={classes.incentive}>{incentiveText(props.quantity, 5)}</Typography>
      
    </footer>
  )
}

}

export default withStyles(useStyles)(CartItem);