<?php

if (isset($_POST['uname']) and isset($_POST['uemail']) and isset($_POST['uphone']) and isset($_POST['umsg'])) {

    function tommus_email_validate($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $email);
    }

    function safeValue($value) {
        return trim(strip_tags(stripcslashes($value)));
    }

    // variables
    $name = $_POST['uname'];
    $email = $_POST['uemail'];
    $phone = $_POST['uphone'];
    $comments = $_POST['umsg'];
    // values empty conditions 
    if (empty($name)) {
        exit('<div class="error_message"><h4>Error !</h4><p>You must enter your name</p></div>');
    } else if (empty($email)) {
        exit('<div class="error_message"><h4>Error !</h4><p>Please enter a valid email address</p></div>');
    } else if (!tommus_email_validate($email)) {
        exit('<div class="error_message"><h4>Error !</h4><p>You have entered an invalid e-mail address</p></div>');
    } else if (empty($phone)) {
        exit('<div class="error_message"><h4>Error !</h4><p>Please enter a valid phone</p></div>');
    } else if (empty($comments)) {
        exit('<div class="error_message"><h4>Error !</h4><p>Please enter your message</p></div>');
    } else {
        // mail setting
        $address = 'abdo.host@yahoo.com';
        $s_subject = 'You\'ve been contacted by ' . $name . '.';
        $s_body = "You have been contacted by $name from your contact form, their additional message is as follows." . "\r\n" . "\r\n";
        $s_content = "\"$comments\"" . "\r\n" . "\r\n";
        $s_reply = "You can contact $name , phone : $phone , via email: $email";
        // msg
        $msg = wordwrap($s_body . $s_content . $s_reply, 70);
        $headers = "From: $email" . "\r\n";
        $headers .= "Reply-To: $email" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/plain; charset=utf-8" . "\r\n";
        $headers .= "Content-Transfer-Encoding: quoted-printable" . "\r\n";
        // send mail
        if (mail($address, $s_subject, $msg, $headers)) {
            echo "<div class='success_message'><h4>Email Sent Successfully.</h4><p>Thank you $name, your message has been submitted to us.</p></div>";
        }
    }
}
?>