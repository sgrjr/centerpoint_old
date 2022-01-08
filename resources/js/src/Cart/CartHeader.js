import React, {useState} from 'react'
import Button from '@material-ui/core/Button'
import IconPicker from '../components/IconPicker';
import IconButton from '@material-ui/core/IconButton'
import { makeStyles } from '@material-ui/core/styles'
import TextField from '@material-ui/core/TextField'
import Typography from '@material-ui/core/Typography'
import cartUpdateMutation from './cartUpdateMutation'

const useStyles = makeStyles({
	heading: {
		lineHeight: '1',
		paddingTop: '8px',
		paddingBottom: '8px'
	},
	icon: {
		lineHeight: '1',
		marginLeft: '.5rem',
		'& svg': {
			fontSize: '1rem'
		}
	},
	field: {
		'& input': {
			paddingTop: '6px'
		}
	}
})

function CartHeader(props) {
  const classes = useStyles()
  let [editable, setEditable] = useState(false)
  let [po, setPo] = useState(props.cart.PO_NUMBER)

  const handleClick = (e) => {

  	const properties = {id: props.cart.id, INDEX:props.cart.INDEX, PO_NUMBER: po}
  	console.log(properties)
	const query = cartUpdateMutation({input: properties})
	props.cartSave(query)
    setEditable(editable === true ? false: true)
  }

  const handleUpdate = (e) => {
	setPo(e.target.value);
  }

  const handleReset = (e) => {	
	setEditable(false)
	setPo(props.cart.PO_NUMBER);
	e.stopPropagation();
  }

  const handleBlur= (e) => {
    setEditable(editable === true ? false: true)
	e.stopPropagation();
  }

	let title
	if (editable) {
		let buttons1 = null
		let buttons2 = 	null
		
		if(props.cart.PO_NUMBER !== po){
			buttons1 = <Button onClick={handleReset} size="small">Reset</Button>
			buttons2 = <Button onClick={handleClick} size="small">Save</Button>
		}

		title = <>
			<TextField 
				className={classes.field}
				label="PO#"
				value={po}
				onChange={(e)=>{handleUpdate(e)}}
				onKeyPress={event => {
					if (event.key === 'Enter') {
						handleClick(event)
					}
        }}

        autoFocus
			/>
			{buttons1}
			{buttons2}
		</>
	} else {
		title = <>
			<Typography className={classes.heading}>{po} ({props.cart.DATE})</Typography>
			<IconButton 
				className={classes.icon}
				aria-label="edit title" 
				onClick={handleBlur}
				size="small"
			>
			  <IconPicker name="create" />
			</IconButton>
		</>
	}

  return (
    <>
    	{title}
    </>
  )
}

export default CartHeader

