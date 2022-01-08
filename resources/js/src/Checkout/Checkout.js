import React from 'react'
import Button from '@material-ui/core/Button'
import ContactInfo from './ContactInfo'
import Divider from '@material-ui/core/Divider'
import IconPicker from '../components/IconPicker'
import { Accordion } from '@material-ui/core'
import AccordionDetails from '@material-ui/core/AccordionActions'
import AccordionActions from '@material-ui/core/AccordionActions'
import AccordionSummary from '@material-ui/core/AccordionSummary'

import OrderSummary from './OrderSummary'
import Typography from '@material-ui/core/Typography'
import { makeStyles } from '@material-ui/core/styles'

const useStyles = makeStyles({
  footer: {
    display: 'flex',
    justifyContent: 'space-between'
  }
})
function Checkout(props) {
  const classes = useStyles()
  const [expanded, setExpanded] = React.useState('panel1')
  
  const handleChange = panel => (event, isExpanded) => {
    setExpanded(isExpanded ? panel : false)
  }
  const handleClick = panel => {
    setExpanded(panel)
  }

  return (
    <>
      <Typography variant="h2">{props.data.invoice.title}</Typography>
      <Accordion expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
        <AccordionSummary 
          expandIcon={<IconPicker name="expand" />}
          aria-controls="panel1a-content"
          id="step-1-header"
        >
          <Typography><strong>Step 1:</strong> Review Items</Typography>
        </AccordionSummary >
        <AccordionDetails>
          <OrderSummary {...props}/>
        </AccordionDetails>
        <Divider />
        <AccordionActions>
          <Button
            variant="contained"
            color="primary"
            endIcon={<IconPicker name="navigateNext"/>}
            onClick={()=> handleClick('panel2')}
          >
            Next Step
          </Button>
        </AccordionActions>
      </Accordion>
      <Accordion expanded={expanded === 'panel2'} onChange={handleChange('panel2')}>
        <AccordionSummary 
          expandIcon={<IconPicker name="expand" />}
          aria-controls="panel1a-content"
          id="step-2-header"
        >
          <Typography><strong>Step 2:</strong> Review Billing Information</Typography>
        </AccordionSummary >
        <AccordionDetails>
          <ContactInfo {...props}/>
        </AccordionDetails>
        <Divider />
        <AccordionActions className={classes.footer}>
          <Button
            startIcon={<IconPicker name="navigateBefore"/>}
            onClick={()=> handleClick('panel1')}
          >
            Previous Step
          </Button>
          <Button
            variant="contained"
            color="primary"
            onClick={()=> props.setIsCompleted(props.data)}
          >
            Submit Order
          </Button>
        </AccordionActions>
      </Accordion>
    </>
  )
}

export default Checkout