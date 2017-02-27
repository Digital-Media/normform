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
            <h2 class="Section-heading">Normform Demo</h2>
        </div>
    </section>
    <section class="Section">
        <div class="Container">
            <h2 class="Section-heading">Result</h2>
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
