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