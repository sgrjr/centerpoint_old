import React from 'react'
import FormControl from '@material-ui/core/FormControl'
import FormGroup from '@material-ui/core/FormGroup'
import { makeStyles } from '@material-ui/core/styles'
import TextField from '@material-ui/core/TextField'

const useStyles = makeStyles({
  form: {
    width: '100%'
  }
})

function ShippingInfo(props) {
  const classes = useStyles()

  const {COMPANY, ATTENTION, STREET, ROOM, DEPT, CITY, STATE, POSTCODE} = props.data

  return (
    <FormControl className={classes.form}>

      <TextField
        className="standard-full-width"
        label="Company name"
        fullWidth
        margin="normal"
        name="COMPANY"
        value={COMPANY? COMPANY:""}
        onChange={props.updateCheckout}
      />

      <FormGroup row={true}>

      <TextField
        className="standard-full-width"
        label="Attention"
        margin="normal"
        name="ATTENTION"
        value={ATTENTION? ATTENTION:""}
        onChange={props.updateCheckout}
      />
      <TextField
        className="minimal-width"
        label="Department"
        margin="normal"
        name="DEPT"
        value={DEPT? DEPT:""}
        onChange={props.updateCheckout}
      />

      <TextField
        className="minimal-width"
        label="Room"
        margin="normal"
        name="ROOM"
        value={ROOM? ROOM:""}
        onChange={props.updateCheckout}
      />
      </FormGroup>

      <TextField
        id="standard-full-width"
        label="Street Address"
        fullWidth
        margin="normal"
        name="STREET"
        value={STREET? STREET:""}
        onChange={props.updateCheckout}
      />
      <FormGroup row={true}>
        <TextField
          className="standard-full-width"
          label="City"
          margin="normal"
          name="CITY"
          value={CITY? CITY:""}
          onChange={props.updateCheckout}
        />
        <TextField
          className="standard-full-width"
          label="State"
          margin="normal"
          name="STATE"
          value={STATE? STATE:""}
          onChange={props.updateCheckout}
        />
        <TextField
          className="standard-full-width"
          label="Zip/Postal Code"
          margin="normal"
          name="POSTCODE"
          value={POSTCODE? POSTCODE:""}
          onChange={props.updateCheckout}
        />
      </FormGroup>
    </FormControl>
  )
}

export default ShippingInfo