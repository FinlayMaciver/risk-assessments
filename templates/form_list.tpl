{* Smarty *}
<p>
<form method="POST" action="{$smarty.server.PHP_SELF}">
<input type="hidden" value="search" name="action" />
<input type="hidden" value="any" name="f" />
<input type="text" name="q" value="" size="30" /> <input type="submit" name="search" value="Search" />
</form>
</p>
<table width="100%">
<tr>
    <th class="adminth"><a href="{$smarty.server.PHP_SELF}?sf=data.title">Title</a></th>
    <th class="adminth"><a href="{$smarty.server.PHP_SELF}?sf=data.personemail">Person</a></th>
    <th class="adminth"><a href="{$smarty.server.PHP_SELF}?sf=data.location">Location</a></th>
    <th class="adminth"><a href="{$smarty.server.PHP_SELF}?sf=UploadDate">Uploaded</a></th>
    <th class="adminth"><a href="{$smarty.server.PHP_SELF}?sf=LastUpdated">Updated</a></th>
    <th class="adminth"><a href="{$smarty.server.PHP_SELF}?sf=Status">Status</a></th>
</tr>
{foreach from=$forms item=form}
<tr bgcolor="{cycle values="#FFFFFF,#EEEEFF"}">
    <td> <a href="sendpdf.php?id={$form.uuid}"><img src="pdf_icon.png" alt="[PDF]" /></a> <a href="{$smarty.server.PHP_SELF}?action=view&amp;id={$form.uuid}">{$form.Title}</a></td>
    <td><a href="{$smarty.server.PHP_SELF}?action=search&amp;q={$form.SubmittedBy|escape:'url'}&amp;f=data.personemail">{$form.SubmittedBy}</a></td>
    <td>{$form.Location}</td>
    <td>{$form.UploadDate|date_format}</td>
    <td>{$form.LastUpdated|date_format}</td>
    <td bgcolor="{if $form.Status eq "Approved"}#CCFFCC{elseif $form.Status eq "Rejected"}#FFCCCC{/if}">{$form.Status}</td>
</tr>
{/foreach}
</table>

