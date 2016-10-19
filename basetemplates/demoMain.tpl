<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$smarty.const.TITLE}</title>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/main.css">
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
            {/if}            <form action="{$smarty.server.SCRIPT_NAME}" method="post" enctype="multipart/form-data">
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
                    <textarea name="{$nachrichtKey}" id="{$nachrichtKey}" rows="5" cols="60">{if isset($nachrichtValue)}{$nachrichtValue}{/if}</textarea>
                </div>
                <div class="Grid-full">
                    <button type="submit" class="Button">Send</button>
                </div>
            </form>
        </div>
    </section>
    <section class="Section">
        <div class="Container">
            {if isset($smarty.post)}
                <h2 class="Section-heading">Result</h2>
                {foreach $smarty.post as $k => $v}
                    <em>{$k} :</em>
                    <br/>
                    {$v|escape|nl2br}
                    <br/>
                {/foreach}
            {/if}
        </div>
    </section>
</main>
<footer class="Site-footer">
    <div class="Footer Footer--small">
        <p class="Footer-credits">Created and maintained by <a href="mailto:martin.harrer@fh-hagenberg.at">Martin Harrer</a> and <a href="mailto:wolfgang.hochleitner@fh-hagenberg.at">Wolfgang Hochleitner</a>.</p>
        <p class="Footer-version"><i class="fa fa-shopping-bag" aria-hidden="true"></i>TNormfrom Demo Version 2016</p>
    </div>
</footer>
<script src="../../js/lightbox.min.js" type="text/javascript"></script>
<script>
    var lightbox = new Lightbox();
    lightbox.load();
</script>
</body>
</html>
