import React from 'react'
import Button from '../components/Button'
import ListItem from '@material-ui/core/ListItem'
import FormControl from '@material-ui/core/FormControl'
import Select from '@material-ui/core/Select'
import MenuItem from '@material-ui/core/MenuItem'
import Typography from '@material-ui/core/Typography'
import { createStyles, makeStyles, useTheme } from '@material-ui/core/styles'
import grey from '@material-ui/core/colors/grey'
import {Link} from 'react-router-dom'
const fontSize = '.8rem'
const colorAccent = grey[600]
import IconPicker from '../components/IconPicker';

const useStyles = makeStyles((theme) => createStyles ({
  container: {
    display: 'grid',
    gridTemplateColumns: 'minmax(auto, 80px) 1fr auto',
    gridColumnGap: '10px',
    gridRowGap: '5px',
    minWidth: '30vw'
  },
  title: {
  	fontSize: '1rem',
  	gridColumn: 'span 2',
  	fontWeight: 'bold'
  },
  author: {
  	gridColumn: 'span 2',
  	fontSize: fontSize,
  	color: colorAccent,
    lineHeight: '1.2'
  },
  priceLabel: {
  	fontSize: fontSize,
  	color: colorAccent,
  	justifySelf: 'right',
    lineHeight: '1.2'
  },
  price: {
  	fontSize: fontSize,
  	color: colorAccent,
  	lineHeight: '1.2'
  },
  quantity: {
  	flexDirection: 'row',
  	alignItems: 'center',
  	marginTop: '-5px'
  },
  quantityLabel: {
  	fontSize: fontSize,
  	color: colorAccent,
  	justifySelf: 'right',
  	alignSelf: 'start',
  	lineHeight: '1.2'
  },
  quantitySelect: {
  	marginTop: '0 !important',
  	fontSize: fontSize
  },
  imageContainer: {
  	gridRow: '1 / span 5'
  },
  image: {
  	width: '100%'
  },
  remove: {
    justifySelf: 'end'
  },
  total: {
  	fontWeight: 'bold',
  	fontSize: fontSize,
  	lineHeight: '1.2'
  }
}))

const options = ()=>{
  let i = 0;
  let items = []
  while(i < 100){
    i++;
    items.push(<MenuItem key={i} value={i}>{i}</MenuItem>)
  }
  return items
}

function CartItem(props) {
  const theme = useTheme()
	const classes = useStyles(theme)

  return (
    <ListItem className={classes.container}>
    	<div className={classes.imageContainer} style={{background:"#3F51B5"}}>
    		<img className={classes.image} src={`${props.coverArt}`} alt={`${props.TITLE} cover`}/>
    	</div>
    	<h3 className={classes.title}><Link to={"/isbn/"+props.PROD_NO}>{props.TITLE}</Link></h3>
    	<p className={classes.author}>By {props.AUTHOR}</p>
    	<p className={classes.priceLabel}>Item price: </p>
    	<p className={classes.price}>${props.SALEPRICE}</p>
    	<label className={classes.quantityLabel}>Quantity: </label>
    	<FormControl className={classes.quantity}>
        <Select
          labelId="demo-simple-select-outlined-label"
          id={'quantity'}
          value={props.REQUESTED}
          className={classes.quantitySelect}
          onChange={(e)=>{
            let attributes = {id: parseInt(props.id), REQUESTED: parseInt(e.target.value)}
            props.updateTitleQuantity(attributes)
          }}
        >

          {options()}
          
        </Select>
      </FormControl>
      <Button
      	variant="outlined" 
      	size="small"
        className={classes.remove}
        color="error"
        onClick={()=>{props.deleteFromCart({id: parseInt(props.id), data:props})}}
        startIcon={<IconPicker icon="delete" />}
      >
      </Button>
      <p className={classes.total}>{`$${(props.REQUESTED * props.SALEPRICE).toFixed(2)}`}</p>
    </ListItem>
  )
}

export default CartItem