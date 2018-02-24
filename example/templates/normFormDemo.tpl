<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NormForm Example</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
</head>
<body class="Site">
<header class="Site-header">
    <div class="Header Header--small">
        <div class="Header-titles">
            <h1 class="Header-title"><i class="fa fa-file-text-o" aria-hidden="true"></i>NormForm</h1>
            <p class="Header-subtitle">Example Implementation</p>
        </div>
    </div>
</header>
<main class="Site-content">
    <section class="Section">
        <div class="Container">
            <h2 class="Section-heading">Enter Your Name and Message</h2>
            {if isset($errorMessages) && count($errorMessages) > 0}
                <div class="Error">
                    <ul class="Error-list">
                        {foreach $errorMessages as $error}
                            <li class="Error-listItem">{$error}</li>
                        {/foreach}
                    </ul>
                </div>
            {/if}
            {if isset($statusMessage) && strlen($statusMessage) !== 0}
                <div class="Status">
                    <p class="Status-message"><i class="fa fa-check"></i>{$statusMessage}</p>
                </div>
            {/if}
            <form action="{$smarty.server.SCRIPT_NAME}" method="post">
                <div class="Grid Grid--gutters">
                    <div class="InputCombo Grid-full">
                        <label for="{$firstname->getName()}" class="InputCombo-label">First Name*:</label>
                        <input type="text" id="{$firstname->getName()}" name="{$firstname->getName()}" value="{$firstname->getValue()}" class="InputCombo-field">
                    </div>
                    <div class="InputCombo Grid-full">
                        <label for="{$lastname->getName()}" class="InputCombo-label">Last Name*:</label>
                        <input type="text" id="{$lastname->getName()}" name="{$lastname->getName()}" value="{$lastname->getValue()}" class="InputCombo-field">
                    </div>
                    <div class="InputCombo Grid-full">
                        <label for="{$message->getName()}" class="InputCombo-label">Message:</label>
                        <textarea name="{$message->getName()}" id="{$message->getName()}" class="InputCombo-field">{$message->getValue()}</textarea>
                    </div>
                    <div class="Grid-full">
                        <button type="submit" class="Button">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="Section">
        <div class="Container">
            <h2 class="Section-heading">Result in $_POST</h2>
            {if isset($result)}
                <table class="Table u-tableW100">
                    <colgroup span="2" class="u-tableW50"></colgroup>
                    <thead>
                    <tr class="Table-row">
                        <th class="Table-header">Key</th>
                        <th class="Table-header">Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach $result as $key => $value}
                        <tr class="Table-row">
                            <td class="Table-data">{$key}</td>
                            <td class="Table-data">{$value|escape|nl2br}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            {/if}
        </div>
    </section>
</main>
<footer class="Site-footer">
    <div class="Footer Footer--small">
        <p class="Footer-credits">Created and maintained by <a href="mailto:martin.harrer@fh-hagenberg.at">Martin Harrer</a> and <a href="mailto:wolfgang.hochleitner@fh-hagenberg.at">Wolfgang Hochleitner</a>.</p>
        <p class="Footer-version"><i class="fa fa-file-text-o" aria-hidden="true"></i><a href="https://github.com/Digital-Media/normform">NormForm Example Version 2017</a></p>
    </div>
</footer>
</body>
</html>
