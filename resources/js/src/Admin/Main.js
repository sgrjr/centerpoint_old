import React from 'react'
import Grid from '@material-ui/core/Grid'
import Widget from '../components/Widget'
import QueryTester from './QueryTester'
import CircularProgress from '@material-ui/core/CircularProgress';

export default function Main(props) {
  
  const handleGetAdminQuery = (e)=>{
    props.adminGet(props.adminQuery) 
  }

  const handleGetTitlesQuery = (e)=>{
    props.titlesGet(props.titlesQuery) 
  }

  const handleGetTitleQuery = (e)=>{
    props.titleGet(props.titleQuery) 
  }

  const handleCartsQuery = (e)=>{
    props.cartGet(props.cartQuery) 
  }

  const handleNavbarViewerQuery = (e)=>{
    props.fetchViewer(props.navbarQuery) 
  }

  const progress = (pending)=>{
    if(pending){
      return <CircularProgress />
    }else{
      return ((props.progress.end - props.progress.start)/1000) +  " seconds"
    }
  }
  return (
    <Grid container spacing={3} style={{border:"solid 2px blue", overflowX:"hidden"}}>

            <div style={{position:"fixed", bottom:"15px", right:"15px"}}>{progress(props.pending)}</div>

            <Grid item xs={12} md={6}>
              <Widget ready={"hide"}>
              <QueryTester false="ADMIN ERRORS" data={props.errors} />
              </Widget>
            </Grid>

           <Grid item xs={12}>
              <Widget ready={true}>
              <QueryTester title="NOTIFICATIONS" data={props.notification} />       
              </Widget>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
            <Widget ready={true}>
              <button onClick={handleNavbarViewerQuery}>viewer from navbar</button>
              <QueryTester title="VIEWER" data={props.viewer} />
            </Widget>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
              <Widget ready={true}>
                <QueryTester title="CUSTOM" data={props.admin} />
              </Widget>
            </Grid>

            <Grid item xs={12} md={6}>
              <Widget ready={true}>
                <textarea value={props.adminQuery.query} onChange={props.updateAdminQuery} name="query" style={{width:"100%", height:"200px"}}>
                </textarea>
                <input type="submit" value={"submit"} onClick={handleGetAdminQuery}/>
              </Widget>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
            <Widget ready={true}>
              <button onClick={handleGetTitlesQuery}>titles</button>
              <button onClick={handleGetTitleQuery}>a title</button>
              <QueryTester title="TITLES" data={props.titles} />
            </Widget>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
            <Widget ready={true}>
              <button onClick={handleCartsQuery}>carts</button>
              <QueryTester title="CARTS" data={props.carts} />
            </Widget>
            </Grid>

            <Grid item xs={12} md={8} lg={7}>
            <Widget ready={true}>
              <h2>Queries</h2>

              <ul>
                <li>TITLES:</li>
                <li>{JSON.stringify(props.titlesQuery)}</li>
                <li>A TITLE:</li>
                <li>{JSON.stringify(props.titleQuery)}</li>
                <li>NAVBAR:</li>
                <li>{JSON.stringify(props.navbarQuery)}</li>
                <li>CART:</li>
                <li>{JSON.stringify(props.cartQuery)}</li>
              </ul>

            </Widget>
            </Grid>


    </Grid>
  );
}
