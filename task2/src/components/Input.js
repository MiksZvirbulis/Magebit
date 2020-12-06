import React from 'react'

const Input = props => {
    switch(props.attr.type) {
        case 'text':
        return (
            <>
                <div className="input-group">
                    <input onChange={props.change} id={props.id} type={props.attr.type} {...props.attr} value={props.value} />
                    <button disabled={props.formValid ? null : "disabled"}></button>
                </div>
                <div className="invalid-feedback">
                        {props.valid.messages.map( (message, index) => {
                            return <div key={index}>{message}</div>
                        })}
                </div>
            </>
        )
        case 'checkbox':
            return (
                <>
                <div className="checkbox">
                    <input onChange={props.change} type={props.attr.type} id="terms"/>
                    <label htmlFor="terms" dangerouslySetInnerHTML={{__html: props.attr.placeholder}}></label>
                </div>
                <div className="invalid-feedback">
                    {props.valid.messages.map( message => message )}
                </div>
                </>
            )
        default:
        return null
    }
}

export default Input