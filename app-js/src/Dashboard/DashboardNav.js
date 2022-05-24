import React from 'react';
import List from '@material-ui/core/List';
import ListItem from '@material-ui/core/ListItem';
import ListItemIcon from '@material-ui/core/ListItemIcon';
import ListItemText from '@material-ui/core/ListItemText';
import ListSubheader from '@material-ui/core/ListSubheader';

import Divider from '@material-ui/core/Divider';
import IconPicker from '../components/IconPicker'
import useStyles from './DashboardNavStyle.js'

export default function DashboardNav(props) {

  const {links} = props
  const classes = useStyles();

  return (<React.Fragment>
    <List>
    {links.map(function(link, index){

      if(link.icon === "HEADING"){
      return <div><Divider /><ListSubheader inset>{link.text}</ListSubheader></div>
      }
      return(
             <ListItem button key={index} classes={classes}>
              <ListItemIcon>
              <IconPicker name={link.icon}/>
              </ListItemIcon>
              <ListItemText primary={link.text} />
            </ListItem>
      )

  })}
  </List>

  <Divider />

  </React.Fragment>
  );
}
