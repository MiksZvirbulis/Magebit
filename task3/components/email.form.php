<?php
if(!defined("IN_SYSTEM")){
    header("Location: /");
    exit();
};

if (isset($_POST['subscribe'])) {
    $errors = [];

    if (!isset($_POST['email']) || (isset($_POST['email']) && empty($_POST['email']))) {
        // Checking if email exists in the form OR if it exists, is it empty?
        $errors['email'][] = "Email address is required";
    } else {
        // Email exists and it is not empty. So, let's check validity.

        $colombian_email_pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.+-]+.co$/';

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = "Please provide a valid e-mail address";
        }

        if (preg_match($colombian_email_pattern, $_POST['email'])) {
            $errors['email'][] = "We are not accepting subscriptions from Colombia emails";
        }
    }

    if (!isset($_POST['terms'])) {
        // Checking if checkbox is checked. <<< Can you say this quickly 10 times?
        $errors['checkbox'][] = "You must accept the terms and conditions";
    }

    if (empty($errors)) {
        // Let's get this data flight landed in the database

        $email = htmlspecialchars($_POST['email']);
        $email_provider = substr( strrchr($email, '@'), 1);;
        $db->insert("INSERT INTO `subscriptions` (`email`, `email_provider`, `time`) VALUES (?, ?, ?)", array($email, $email_provider, time()));
    }
}

$memory_email = (isset($_POST['email'])) ? htmlspecialchars($_POST['email']) : "";

?>
<?php if (!isset($errors) || !empty($errors)): ?>

<h1>Subscribe to newsletter</h1>
<h3>Subscribe to our newsletter and get 10% discount on pineapple glasses.</h3>

<form method="POST">
    <div class="input-group">
        <input type="text" name="email" placeholder="Type your email address here" value="<?=$memory_email?>"/>
        <button name="subscribe"></button>
    </div>
    <div class="invalid-feedback">
        <?php
            if (isset($errors) && !empty($errors['email'])) {
                $email_errors = $errors['email'];

                foreach ($email_errors as $error) {
                    echo "<div>" . $error . "</div>";
                }
            }
        ?>
    </div>
    <div class="checkbox">
        <input type="checkbox" name="terms" id="terms">
        <label for="terms">I agree to <a href="#">terms of service</a>.</label>
    </div>
    <div class="invalid-feedback">
        <?php
            if (isset($errors) && !empty($errors['checkbox'])) {
                $email_errors = $errors['checkbox'];

                foreach ($email_errors as $error) {
                    echo "<div>" . $error . "</div>";
                }
            }
        ?>
    </div>
</form>

<?php else: // If no errors ?>

<div class="success-image"></div>
<h1>Thanks for subscribing!</h1>
<h3>You have successfully subscribed to our email listing.<br />Check your email for the discount code.</h3>

<?php endif; ?>