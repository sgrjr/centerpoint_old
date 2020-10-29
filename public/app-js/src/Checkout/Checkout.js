import React from 'react'
import Button from '@material-ui/core/Button'
import ContactInfo from './ContactInfo'
import Divider from '@material-ui/core/Divider'
import ExpandMoreIcon from '@material-ui/icons/ExpandMore'
import ExpansionPanel from '@material-ui/core/ExpansionPanel'
import ExpansionPanelDetails from '@material-ui/core/ExpansionPanelDetails'
import ExpansionPanelActions from '@material-ui/core/ExpansionPanelActions'
import ExpansionPanelSummary from '@material-ui/core/ExpansionPanelSummary'
import NavigateBeforeIcon from '@material-ui/icons/NavigateBefore'
import NavigateNextIcon from '@material-ui/icons/NavigateNext'
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
      <Typography variant="h2">Checkout {props.data.invoice.title}</Typography>
      <ExpansionPanel expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
        <ExpansionPanelSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel1a-content"
          id="step-1-header"
        >
          <Typography><strong>Step 1:</strong> Review Items</Typography>
        </ExpansionPanelSummary>
        <ExpansionPanelDetails>
          <OrderSummary {...props}/>
        </ExpansionPanelDetails>
        <Divider />
        <ExpansionPanelActions>
          <Button
            variant="contained"
            color="primary"
            endIcon={<NavigateNextIcon/>}
            onClick={()=> handleClick('panel2')}
          >
            Next Step
          </Button>
        </ExpansionPanelActions>
      </ExpansionPanel>
      <ExpansionPanel expanded={expanded === 'panel2'} onChange={handleChange('panel2')}>
        <ExpansionPanelSummary
          expandIcon={<ExpandMoreIcon />}
          aria-controls="panel1a-content"
          id="step-2-header"
        >
          <Typography><strong>Step 2:</strong> Review Billing Information</Typography>
        </ExpansionPanelSummary>
        <ExpansionPanelDetails>
          <ContactInfo {...props}/>
        </ExpansionPanelDetails>
        <Divider />
        <ExpansionPanelActions className={classes.footer}>
          <Button
            startIcon={<NavigateBeforeIcon/>}
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
        </ExpansionPanelActions>
      </ExpansionPanel>
    </>
  )
}

export default Checkout