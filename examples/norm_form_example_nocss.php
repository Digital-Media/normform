<?php
/**
 * The PHP norm form is used to gather, validate and process form data in a flexible way.
 *
 * This file represents a well known process of gathering, validating and processing form data within a single
 * PHP structure. At the initial request, the form is shown and data can be entered. Once the form is submitted
 * the input is validated. If errors occurred they are being displayed together with the form (which already
 * contains correctly entered input). When the form was filled out correctly, the result is displayed.
 * The norm form also ensures that user input is sanitized in order to avoid cross site scripting.
 * To use this procedural version of norm form, simple change the parts you want to modify or extend. This will
 * most likely be @show_form(), @is_valid_form() and @process_form().
 *
 * @author Rimbert Rudisch-Sommer <rimbert.rudisch-sommer@fh-hagenberg.at>
 * @author Wolfgang Hochleitner <wolfgang.hochleitner@fh-hagenberg.at>
 * @author Martin Harrer <martin.harrer@fh-hagenberg.at>
 * @version 2017
 */

/**
 * @var string FIRST_NAME Form field constant that defines how the form field for holding a first name is called
 * (id/name).
 */
define("FIRST_NAME", "first_name");

/**
 * @var string LAST_NAME Form field constant that defines how the form field for holding a last name is called
 * (id/name).
 */
define("LAST_NAME", "last_name");

/**
 * @var string MESSAGE Form field constant that defines how the form field for holding a message is called (id/name).
 */
define("MESSAGE", "message");

/**
 * Main "decision" function for the form processing. This decision tree uses is_form_submission() to check if the form
 * is being initially displayed or shown again after a form submission and either calls show_form() to display the form
 * or validate the received input in is_valid_form(). If validation failed, show_form() is called again. Possible
 * error messages can now be displayed. Once the submission was correct, process_form() is called where the data can be
 * processed as needed. Ultimately the form is shown again including the generated output.
 */
function norm_form()
{
    if (is_form_submission()) {
        if (is_valid_form()) {
            process_form();
        }
    }
    show_form();
}

/**
 * Checks if the current request was an initial one (thus using GET) or a recurring one after a form submission (where
 * POST was used).
 * @return bool Returns true if a form was submitted or false if it was an initial call.
 */
function is_form_submission(): bool
{
    return ($_SERVER["REQUEST_METHOD"] === "POST");
}

/**
 * Validates the form submission. The criteria for this example are non-empty fields for first and last name. These are
 * checked using is_empty_post_field() in two separate if-clauses. If a criterion is violated, an entry in
 * $error_messages is created. If no error messages where created, validation is seen as successful.
 * @return bool Returns true if validation was successful, otherwise false.
 */
function is_valid_form(): bool
{
    global $error_messages;

    if (is_empty_post_field(FIRST_NAME)) {
        $error_messages[FIRST_NAME] = "First name is required.";
    }
    if (is_empty_post_field(LAST_NAME)) {
        $error_messages[LAST_NAME] = "Last name is required.";
    }

    return !isset($error_messages);
}

/**
 * Convenience function to check if a form field is empty, thus contains only an empty string. This is preferred to
 * PHP's own empty() method which also defines inputs such as "0" as empty.
 * @param string $index The index in the superglobal $_POST array.
 * @return bool Returns true if the form field is empty, otherwise false.
 */
function is_empty_post_field($index): bool
{
    return (!isset($_POST[$index]) || strlen(trim($_POST[$index])) === 0);
}

/**
 * Business logic method used to process the data that was used after a successful validation. In this example the
 * received data is stored in the global variable @result and later displayed. In more complex scenarios this would
 * be the place to add things to a database or perform other tasks before displaying the data.
 */
function process_form()
{
    global $result;
    global $status_message;

    $result = $_POST;
    $status_message = "Processing successful!";
}

/**
 * Used to display output. First, it generates output for error messages and a status message if those were set in
 * is_valid_form(). Then the form is displayed where this output is used.
 */
function show_form()
{
    generate_error_messages();
    generate_status_message();
    generate_result();
    display();
}

/**
 * Generates an HTML fragment containing all error messages that occurred while validating the form. This fragment is
 * then used in display() to show the error messages.
 */
function generate_error_messages()
{
    global $error_messages;
    global $error_fragment;

    if (isset($error_messages)) {
        $error_fragment .= "<ul>" . PHP_EOL;
        foreach ($error_messages as $e) {
            $error_fragment .= "<li>$e</li>" . PHP_EOL;
        }
        $error_fragment .= "</ul>" . PHP_EOL;
    }
}

/**
 * Generates an HTML fragment containing a status message if one was set in process_form(). This fragment is then used
 * in display() to show the status message.
 */
function generate_status_message()
{
    global $status_message;
    global $status_fragment;

    if (isset($status_message)) {
        $status_fragment .= "<p>$status_message</p>" . PHP_EOL;
    }
}

/**
 * Generates an HTML fragment containing the result if one was set in process_form(). This fragment is then used in
 * display() to show the status message.
 */
function generate_result()
{
    global $result;
    global $result_fragment;

    if (isset($result)) {
        $result_fragment = "<table border='1'>" . PHP_EOL;
        $result_fragment .= "<thead>" . PHP_EOL;
        $result_fragment .= "<tr>" . PHP_EOL;
        $result_fragment .= "<th>Key</th>" . PHP_EOL;
        $result_fragment .= "<th>Value</th>" . PHP_EOL;
        $result_fragment .= "</tr>" . PHP_EOL;
        $result_fragment .= "</thead>" . PHP_EOL;
        $result_fragment .= "<tbody>" . PHP_EOL;
        foreach ($result as $key => $value) {
            $result_fragment .= "<tr>" . PHP_EOL;
            $result_fragment .= "<td>$key</td>" . PHP_EOL;
            $result_fragment .= "<td>" . nl2br(sanitize_filter($value)) . "</td>" . PHP_EOL;
            $result_fragment .= "</tr>" . PHP_EOL;
        }
        $result_fragment .= "</tbody>" . PHP_EOL;
        $result_fragment .= "</table>" . PHP_EOL;
    }
}

/**
 * Creates the full HTML page (form and output) and displays it. Fragments for error messages, status message and result
 * are inserted if available.
 */
function display()
{
    global $error_fragment;
    global $status_fragment;
    global $result_fragment;

    $script_name = $_SERVER["SCRIPT_NAME"];
    $first_name_key = FIRST_NAME;
    $last_name_key = LAST_NAME;
    $message_key = MESSAGE;

    // Upon successful processing the values from the form fields are being emptied.
    if (isset($error_fragment)) {
        $first_name_value = autofill_form_field(FIRST_NAME);
        $last_name_value = autofill_form_field(LAST_NAME);
        $message_value = autofill_form_field(MESSAGE);
    } else {
        $first_name_value = null;
        $last_name_value = null;
        $message_value = null;
    }

    // The HEREDOC syntax is used to store the markup for the whole page in a string.
    $page = <<<PAGE
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>norm_form Example</title>
        </head>
        <body>
        <header>
            <h1>norm_form Example Implementation</h1>
        </header>
        <main>
            <section>
                <h2>Enter Your Name and Message</h2>
                $error_fragment
                $status_fragment
                <form action="$script_name" method="post">
                    <div>
                        <label for="$first_name_key">First Name*:</label><br>
                        <input type="text" id="$first_name_key" name="$first_name_key" value="$first_name_value">
                    </div>
                    <div>
                        <label for="$last_name_key">Last Name*:</label><br>
                        <input type="text" id="$last_name_key" name="$last_name_key" value="$last_name_value">
                    </div>
                    <div>
                        <label for="$message_key">Message:</label><br>
                        <textarea name="$message_key" id="$message_key" rows="5" cols="60">$message_value</textarea>
                    </div>
                    <div>
                        <button type="submit">Send</button>
                    </div>
                </form>        
            </section>
            <section>
                <h2>Result in \$_POST</h2>
                $result_fragment
            </section>
        </main> 
        <hr>
        <footer>
            <p>Created and maintained by <a href="mailto:martin.harrer@fh-hagenberg.at">Martin Harrer</a> and 
                <a href="mailto:wolfgang.hochleitner@fh-hagenberg.at">Wolfgang Hochleitner</a>.
                <a href="https://github.com/Digital-Media/normform">norm_form Example Version 2017</a>
            </p>
        </footer>
        </body>
        </html>
PAGE;

    // Then this string is being displayed using echo.
    echo $page;
}

/**
 * This function is responsible for filling in correct values in a resubmitted form. It checks if a value for the
 * specified form field already exists in $_POST. If yes, this value is sanitized and returned (to avoid cross site
 * scripting). If not, an empty string is returned. Additionally, unnecessary white spaces are removed.
 * @param string $name The name of the form field that should be processed.
 * @return string Returns the sanitized value in $_POST or an empty string.
 */
function autofill_form_field(string $name): string
{
    return isset($_POST[$name]) ? trim(sanitize_filter($_POST[$name])) : "";
}

/**
 * Filters unnecessary HTML tags from a string and returns the sanitized text.
 * @param string $str The input string with possible harmful content.
 * @return string The sanitized string that can be safely used.
 */
function sanitize_filter(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5);
}

// --- This is the main call of the norm form process

norm_form();
