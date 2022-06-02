import React from 'react'
import FormControl from '@material-ui/core/FormControl'
import { makeStyles } from '@material-ui/core/styles'
import TextField from '@material-ui/core/TextField'

const useStyles = makeStyles({
  form: {
    width: '100%'
  }
})

function BillingInfo(props) {
  const classes = useStyles()

  const {BILL_1, BILL_2, BILL_3, BILL_4, BILL_5, CINOTE, PO_NUMBER} = props.data

  return (
    <FormControl className={classes.form}>

      <TextField
        className="standard-full-width"
        label="PO#"
        fullWidth
        margin="normal"
        name="PO_NUMBER"
        value={PO_NUMBER? PO_NUMBER:""}
        onChange={props.updateCheckout}
      />

      <TextField
        className="standard-full-width"
        label="Company Name"
        fullWidth
        margin="normal"
        name="BILL_1"
        value={BILL_1? BILL_1:""}
        onChange={props.updateCheckout}
      />
      <TextField
        id="standard-full-width"
        label="Contact Name"
        fullWidth
        margin="normal"
        name="BILL_2"
        value={BILL_2? BILL_2:""}
        onChange={props.updateCheckout}
      />
      <TextField
        className="standard-full-width"
        label="Street Address"
        fullWidth
        margin="normal"
        name="BILL_3"
        value={BILL_3? BILL_3:""}
        onChange={props.updateCheckout}
      />
      <TextField
        className="standard-full-width"
        label="City, State, and Zip Code"
        fullWidth
        margin="normal"
        name="BILL_4"
        value={BILL_4? BILL_4:""}
        onChange={props.updateCheckout}
      />
      <TextField
        className="standard-full-width"
        label="Memo"
        fullWidth
        margin="normal"
        name="CINOTE"
        value={CINOTE? CINOTE:""}
        onChange={props.updateCheckout}
      />
    </FormControl>
  )
}

export default BillingInfo