{* Smarty *}

<div class="fieldgroup">
<p>
    Title of task or activity :<br />
    <input type="text" value="{$form.data.title}" disabled="disabled"/>
</p>

<p>
    Location(s) where work will take place :<br />
    <span class="fakefield">{$form.data.location}</span>
</p>
</div>

<hr />

<form method="POST" action="approve.php">
<input type="hidden" name="action" value="approve" />
<input type="hidden" name="uuid" value="{$form.uuid}" />

<p>
    <input type="submit" name="approve" value="Approve" />
    <br />&nbsp;<br />
    Reason for rejection : <input type="text" name="rejectreason" value="" size="60" />
    <input type="submit" name="reject" value="Reject" />
</p>

</form>

<hr />
