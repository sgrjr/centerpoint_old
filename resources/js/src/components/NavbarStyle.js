import { makeStyles } from '@material-ui/core/styles';

const useStyles = makeStyles(theme => ({

  title: {
    [theme.breakpoints.up('sm')]: {
      display: 'block',
    },
    width:"100%",
    height:"75px"
  },
  search: {
    position: 'relative',
    border:"none",
    [theme.breakpoints.up('sm')]: {
      marginLeft: theme.spacing(3),
      width: 'auto',
    },
  },
  searchIcon: {},
  inputInput: {
    padding: theme.spacing(1, 1, 1, 7),
    transition: theme.transitions.create('width'),
    width: '100%',
    [theme.breakpoints.up('md')]: {
      width: 200,
    },
  },
  sectionDesktop: {
    display: 'none',
    [theme.breakpoints.up('md')]: {
      display: 'flex',
    },
  },
  sectionMobile: {
    display: 'flex',
    [theme.breakpoints.up('md')]: {
      display: 'none',
    },
  },
  menuItem: {},
  logo: {
    width:"100%",
    margin:"auto",
    maxWidth:"450px",
    display:"block",
    height:"75px"
  }
}));

export default useStyles;