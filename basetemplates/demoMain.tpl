<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo TNormform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="Site">
<main class="Site-content">
    <section class="Section">
        <div class="Container">
            <h2 class="Section-heading">TNormform Demo</h2>
            {if count($errorMessages) > 0}
                <div class="Error">
                    <ul class="Error-list">
                        {foreach $errorMessages as $error}
                            <li class="Error-listItem">{$error}</li>
                        {/foreach}
                    </ul>
                </div>
            {/if}
            {if strlen($statusMessage) != 0}
                <div class="Status">
                    <p class="Status-message"><i class="fa fa-check"></i>{$statusMessage}</p>
                </div>
            {/if}
            <form action="{$smarty.server.SCRIPT_NAME}" method="post" enctype="multipart/form-data">
                <div class="Grid Grid--gutters">
                    <div class="InputCombo Grid-full">
                        <label for="{$vornameKey}" class="InputCombo-label">Vorname:</label>
                        <input type="text" id="{$vornameKey}" name="{$vornameKey}" value="{if isset($vornameValue)}{$vornameValue}{/if}" class="InputCombo-field">
                    </div>
                    <div class="InputCombo Grid-full">
                        <label for="{$nachnameKey}" class="InputCombo-label">Nachname:</label>
                        <input type="text" id="{$nachnameKey}" name="{$nachnameKey}" value="{if isset($nachnameValue)}{$nachnameValue}{/if}" class="InputCombo-field">
                    </div>
                    <div class="InputCombo Grid-full">
                        <label for="{$nachrichtKey}" class="InputCombo-label">Nachricht:</label>
                        <textarea name="{$nachrichtKey}" id="{$nachrichtKey}" class="InputCombo-field">{if isset($nachrichtValue)}{$nachrichtValue}{/if}</textarea>
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
        <p class="Footer-version"><i class="fa fa-file-text-o" aria-hidden="true"></i>TNormform Demo Version 2017</p>
        <p class="Footer-credits"><i class="fa fa-github" aria-hidden="true"></i><a href="https://github.com/Digital-Media/normform">GitHub</a></p>
    </div>
</footer>
</body>
</html>
