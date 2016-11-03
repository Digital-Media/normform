<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$smarty.const.TITLE}</title>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{$smarty.const.CSSPATH}/main.css">
</head>
<body class="Site">
<header class="Site-header">
    <div class="Header Header--small">
        <div class="Header-titles">
            <h1 class="Header-title"><a href="index.php">{$smarty.const.ICON}{$smarty.const.TITLE}</a></h1>
            <p class="Header-subtitle">{$smarty.const.SUBTITLE}</p>
        </div>
        <div class="Header-logout">
            {if isset($smarty.session.ISLOGGEDIN)}<span> Your are Logged In as {if isset($smarty.session.first_name)}{$smarty.session.first_name}{/if} {if isset($smarty.session.last_name)}{$smarty.session.last_name}{/if} : <a href="logout.php">Logout</a></span> {else}<span> <a href="login.php">Login</a></span> {/if}<span></span>
        </div>
    </div>
</header>