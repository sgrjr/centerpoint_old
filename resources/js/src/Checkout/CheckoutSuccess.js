import React from 'react'
import Button from '@material-ui/core/Button'
import Divider from '@material-ui/core/Divider'
import { makeStyles } from '@material-ui/core/styles'
import OrderSummary from './OrderSummary'
import IconPicker from '../components/IconPicker'
import Typography from '@material-ui/core/Typography'
import CircularProgress from '@material-ui/core/CircularProgress';
import GetMarc from '../components/GetMarc'

const useStyles = makeStyles({
  invoice: {
    display: 'grid',
    gridTemplateColumns: '1fr 1fr',
    gridGap: '1rem'
  },
  header: {
    display: 'flex',
    justifyContent: 'space-between',
    backgroundColor: 'lightgrey',
    gridColumn: 'span 2',
    padding: '1rem',
    alignItems: 'center',
    '& h1': {
      fontSize: '2rem'
    }
  },
  info: {
    border: '1px solid',
    padding: '1rem',
    '& p': {
      fontSize: '0.875rem'
    }
  },
  bold: {
    fontWeight: 'bold'
  },
  summary: {
    gridColumn: 'span 2'
  },
  footer: {
    '& button': {
      marginLeft: '1rem'
    },
    display: 'flex',
    justifyContent: 'flex-end',
    padding: '1rem 0'
  }
})

function ContactInfo(props) {
  const classes = useStyles()

  const {BILL_1, BILL_2, BILL_3, BILL_4, CINOTE, PO_NUMBER, REMOTEADDR, invoice, TRANSNO} = props.data

  const print = (e)=>{

      //var printContents = document.getElementById("invoice").innerHTML;
      //var originalContents = document.body.innerHTML;
  
      //document.body.innerHTML = printContents;
  
       window.print();
  
       //document.body.innerHTML = originalContents;
        return true;
  }
    
  if(!props.data.INDEX){
    return <CircularProgress color={"secondary"}/>
  }

  let isbns = []

  props.data.items.map(function(item){
    isbns.push(item.ISBN? item.ISBN:item.PROD_NO)
  })
  
  return (

    <>
    <GetMarc isbns={isbns} />

      <article className={classes.invoice}>
        <header className={classes.header}>
          <Typography variant="h1"><img src={invoice.company_logo} width="200px" alt="centerpoint logo"/></Typography>
  <Typography>Order: {invoice.title} <br/> PO#: {PO_NUMBER} <br/> INVOICE#: {TRANSNO? TRANSNO:"(NOT PROCESSED YET)"}</Typography>
        </header>
        <div className={classes.info}>
          <Typography className={classes.bold}>Invoice to:</Typography>
          <Typography>{invoice.customer_name}</Typography>
          {BILL_1 &&
            <Typography>{BILL_1}</Typography>
          }
          {BILL_2 &&
            <Typography>{BILL_2}</Typography>
          }
          {BILL_3 &&
            <Typography>{BILL_3}</Typography>
          }
          {BILL_4 &&
            <Typography>{BILL_4}</Typography>
          }
          {CINOTE &&
            <Typography>Memo: {CINOTE}</Typography>
          }
        </div>
        <div className={classes.info}>
          <Typography className={classes.bold}>Remit Payment to:</Typography>
        <Typography>{invoice.company_name}</Typography>
          <Typography>{invoice.company_address}</Typography>
        </div>
        <OrderSummary {...props} className={classes.summary} />
      </article>
      <Divider />
      <div className={classes.footer + "noPrint"}>
          <Button
            variant="contained"
            color="primary"
            startIcon={<IconPicker icon="print" />}
            onClick={print}
            className="noPrint"
          >
            Print
          </Button>
      </div>
    </>
  )
}

export default ContactInfo