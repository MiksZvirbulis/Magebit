export const isValid = (value, rules) => {
    let isValid = true
    let invalidMessages = []

    if (rules.validEmail) {
        const pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        if (!pattern.test(value)) {
          isValid = false;
          invalidMessages.push(`Please provide a valid e-mail address`)
        }
    }

    if (rules.noColombianEmails) {
        const pattern = new RegExp("^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+.co$")
        if (pattern.test(value)) {
            isValid = false;
            invalidMessages.push(`We are not accepting subscriptions from Colombia
            emails`)
        }
    }

    if (rules.required && value === "") {
        isValid = false
        invalidMessages.push(`Email address is required`)
    }

    if (rules.mustBeChecked && value === false) {
        isValid = false
        invalidMessages.push(`You must accept the terms and conditions`)
    }

    return { isValid, messages: invalidMessages }
}