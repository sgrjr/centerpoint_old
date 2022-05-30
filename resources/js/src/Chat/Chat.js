import React, { Component } from 'react';
import { connect } from 'react-redux'
import PropTypes from 'prop-types';
import actions from '../actions';
import './Chat.scss'

class Chat extends Component{
  constructor(){
    this.users = []
    this.messages = []
  }

    componentDidMount(){

      this.fetch()

       Echo.join('chat')
            .here(users => {
                this.props.setUsers(users);
            })
            .joining(user => {
                this.props.joinUser(user);
            })
            .leaving(user => {
                this.props.exitUser(user)
            })
            .listenForWhisper('typing', ({id, name}) => {
              this.props.userIsTyping(id,name)
            })
            .listen('MessageSent', (event) => {
              this.addMessage({
                  message: event.message.message,
                  user: event.user
              })
            });
    }

    render(){
      return (<>

         </>
        )
    }
}    

Chat.propTypes = {
    classes: PropTypes.object
  };

const mapStateToProps = (state)=>{
return {
    messages: state.chat.messages,
    users: state.chat.users,
    viewer: state.viewer,
     }
}

const mapDispatchToProps = dispatch => {
    return {
      fetchMessages: (query) => {
        dispatch(actions.chat.MESSAGES_GET.creator(query))
      },
      addMessage: (message) => {
        dispatch(actions.chat.MESSAGE_SEND.creator(message))
        }
      },
      setUsers: (users) => {
        dispatch(actions.chat.MESSAGE_ADD_USERS.creator(users))
        }
      },
      joinUser: (user) => {
        dispatch(actions.chat.MESSAGE_JOIN_USER.creator(user))
        }
      },
      exitUser: (user) => {
        dispatch(actions.chat.MESSAGE_EXIT_USER.creator(user))
        }
      },
      userIsTyping: (id, name) => {
        dispatch(actions.chat.MESSAGE_EXIT_USER.creator(user))
        }
      },

    }
  }

export default connect(mapStateToProps, mapDispatchToProps)(Chat)

/*

AT ervery add message i need to reset the user who is typing

 this.users.forEach((user, index) => {
                    if (user.id === event.user.id) {
                        user.typing = false;
                        this.$set(this.users, index, user);
                    }
                });

exit user
this.users = this.users.filter(u => u.id !== user.id);

user is userIsTyping
                this.users.forEach((user, index) => {
                    if (user.id === id) {
                        user.typing = true;
                        this.$set(this.users, index, user);
                    }
                });

// Message sent

this.messages.push();
*/