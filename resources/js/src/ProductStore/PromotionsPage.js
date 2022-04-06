import React, { Component } from 'react';
import styles from "../styles.js"
import {Link} from "react-router-dom"

class PromotionsPage extends Component{

    render(){

      let links = [
        {url:"/static/All_Series_Christian_catalog", text:"All Series Christian"},
        {url:"/static/All_Series_Sterling_catalog", text:"All Series Sterling"},
        {url:"/static/All_Series_Trade_catalog", text:"All Series Trade"},
        {url:"/static/All_Series_Western_catalog", text:"All Series Western"},
        {url:"/static/All_Series_Premier_catalog", text:"All Series Premier"},
        {url:"/static/All_Series_Platinum_catalog", text:"All Series Platinum"},
        {url:"/static/All_Series_Choice_catalog", text:"All Series Choice"},
        {url:"/static/All_Series_Bestseller_catalog", text:"All Series Bestseller"},
        {url:"/static/current_catalog", text:"Current Catalog"},
        {url:"/static/next_catalog", text:"Next Catalog"},
        {url:"/static/Premier_Romance_catalog", text:"Premier Romance"},
        {url:"/static/Premier_Mystery_catalog", text:"Premier Mystery"},
        {url:"/static/Premier_Fiction_Christian_catalog", text:"Premier Fiction"},
        {url:"/static/Platinum_Nonfiction_catalog", text:"Platinum Nonfiction"},
        {url:"/static/Platinum_Romance_catalog", text:"Platinum Romance"},
        {url:"/static/Platinum_Mystery_catalog", text:"Platinum Mystery"},
        {url:"/static/Platinum_Fiction_catalog", text:"Platinum Fiction"}
      ]

      return (<div className={styles.promotions}>
        <h1>Promotions</h1>

        {links.map((l)=>{
          return <div><h2>{l.text}</h2><a href={l.url} target="_blank"className={styles.outlined}>OPEN</a></div>
        })}

        </div>)  
    }
        
} 

export default PromotionsPage