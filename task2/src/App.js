import React from 'react'

// Stylesheet
import './assets/scss/App.scss'

// Components
import Input from './components/Input'

// Utilities
import { handleChange } from './utils/handleChange'

class App extends React.Component {

  state = {
    formData: {
      emailAddress: {
            attr: {
              type: "text",
              placeholder: "Type your email address here"
          },
          value: "",
          valid: { isValid: null, messages: []},
          rules: {
              validEmail: true,
              required: true,
              noColombianEmails: true
          }
      },
      terms: {
        attr: {
          type: "checkbox",
          placeholder: "I agree to <a href=\"/#\">terms of service</a>."
      },
      value: "",
      valid: { isValid: null, messages: []},
      rules: {
        mustBeChecked: true
    }
  }
  },
  formValid: false,
  formSubmitted: false
  }

  handleChange(input, newValue) {
    this.setState(handleChange(this.state, input, newValue))
  }

  handleSubscription(event) {
    event.preventDefault()
    this.setState({...this.state, formSubmitted: true})
  }

  render() {
    let formData = []
    for (let key in this.state.formData) {
        formData.push({ id: key, ...this.state.formData[key] })
    }

    return (
      <div className="App">
        <div id="container">
          <div className="main">
              <div className="nav">
                  <ul>
                      <li className="logo"></li>
                      <li><a href="/#">About</a></li>
                      <li><a href="/#">How it works</a></li>
                      <li><a href="/#">Contact</a></li>
                  </ul>
              </div>
              <div className="content">
                  {this.state.formSubmitted === false ? (
                    <>
                      <h1>Subscribe to newsletter</h1>
                      <h3>Subscribe to our newsletter and get 10% discount on pineapple glasses.</h3>
                      <form onSubmit={(event) => this.handleSubscription(event)}>
                          {formData.map((input, index) => {
                            const value = input.attr.type === 'checkbox' ? 'checked' : 'value'
                            return <Input change={(event) => this.handleChange(input, event.target[value])} key={index} formValid={this.state.formValid} {...input} />
                          } )}
                      </form>
                    </>
                  ) : (
                    <>
                      <div className="success-image"></div>
                      <h1>Thanks for subscribing!</h1>
                      <h3>You have successfully subscribed to our email listing.<br />Check your email for the discount code.</h3>
                    </>
                  )}
                  
                  <hr />
  
                  <div className="social-icons">
                      <a href="/#" className="icon facebook">i</a>
                      <a href="/#" className="icon instagram">i</a>
                      <a href="/#" className="icon twitter">i</a>
                      <a href="/#" className="icon youtube">i</a>
                  </div>
              </div>
          </div>
          <div className="bg"></div>
        </div>
      </div>
    );
  }
}

export default App