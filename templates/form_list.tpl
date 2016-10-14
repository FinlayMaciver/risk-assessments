{* Smarty *}
<p>
<form method="POST" action="{$smarty.server.PHP_SELF}">
<input type="hidden" value="search" name="action" />
<input type="hidden" value="any" name="f" />
<input type="text" name="q" value="" size="30" /> <input type="submit" name="search" value="Search" />
</form>
</p>
<p>
    {if $multiuser}
        <a href="{$smarty.server.PHP_SELF}">Click here for single-user forms</a>
        <br />
        <p>
            To sign up to an existing multi-user form, select the appropriate form
            below, read it through to the end and then enter your e-mail address.
        </p>
        {if $admin}
                 | Create new multi-user : <a href="index.php?action=do-general&amp;multiuser=1">General</a> &bull; <a href="index.php?action=do-bio&amp;multiuser=1">Bio</a> &bull; <a href="index.php?action=do-chem&amp;multiuser=1">Chemical</a>
        {/if}
    {else}
        <a href="{$smarty.server.PHP_SELF}?action=listmulti{if $admin}&amp;admin=true{/if}">Click here for multi-user forms</a>
    {/if}
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
    {if $form.SubType == "Old"}
        <td><a href="{$form.uuid}">{$form.Title}</a></td>
    {else}
        <td> <a href="sendpdf.php?id={$form.uuid}"><img src="pdf_icon.png" alt="[PDF]" /></a> <a href="{$smarty.server.PHP_SELF}?action=view&amp;id={$form.uuid}">{$form.Title}</a></td>
    {/if}
    <td><a href="{$smarty.server.PHP_SELF}?action=search&amp;q={$form.SubmittedBy|escape:'url'}&amp;f=data.personemail">{$form.SubmittedBy}</a></td>
    <td>{$form.Location}</td>
    <td>{$form.UploadDate|date_format}</td>
    <td>{$form.LastUpdated|date_format}</td>
    <td bgcolor="{if $form.Status eq "Approved"}#CCFFCC{elseif $form.Status eq "Rejected"}#FFCCCC{/if}">{$form.Status}</td>
</tr>
{/foreach}
</table>

