import React, { Component } from 'react';
import styles from "../styles.js"

class PromotionsPage extends Component{

    render(){

      let links = [
        {url:"", text:"All Series Christian"},
        {url:"", text:"All Series Sterling"},
        {url:"", text:"All Series Trade"},
        {url:"", text:"All Series Western"},
        {url:"", text:"All Series Premier"},
        {url:"", text:"All Series Platinumn"},
        {url:"", text:"All Series Choice"},
        {url:"", text:"All Series Bestseller"},
        {url:"", text:"CATALOG_2022_03_04"},
        {url:"", text:"CATALOG_2022_01_02"},
        {url:"", text:"Premier Romance"},
        {url:"", text:"Premier Mystery"},
        {url:"", text:"Premier Fiction"},
        {url:"", text:"Platinum Nonfiction"},
        {url:"", text:"Platinum Romance"},
        {url:"", text:"Platinum Mystery"},
        {url:"", text:"Platinum Fiction"}
      ]

      return (<div className={styles.promotions}>
        <h1>Promotions</h1>

        {links.map((l)=>{
          return <div><h2>{l.text}</h2><button className={styles.outlined}>OPEN</button></div>
        })}

        </div>)  
    }
        
} 

export default PromotionsPage