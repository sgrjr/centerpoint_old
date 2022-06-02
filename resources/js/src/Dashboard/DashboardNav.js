import React from 'react';
import IconPicker from '../components/IconPicker'
import {Link} from 'react-router-dom'
import styles from "../styles.js"
import './DashboardNav.scss';

export default function DashboardNav(props) {

  const {links} = props

  return (<React.Fragment>
    <ul id="dashboard_nav">
    {links.map(function(link, index){

      if(link.icon === "HEADING"){
        return <li key={index} className={styles.listHeader}><hr/>{link.text}</li>
      }else{
        return(
            <li key={index}>
             <Link to={link.url}><IconPicker icon={link.icon}/> {link.text}</Link>
            </li>
      )
    }

  })}
  </ul>

  </React.Fragment>
  );
}
