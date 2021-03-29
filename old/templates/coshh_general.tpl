{* Smarty *}

{include file="coshh_common_top.tpl"}
<input type="hidden" name="formtype" value="general" />
<p />

<fieldset>
    <legend>(Bio)Chemicals or micro-organisms involved (hazardous or otherwise)</legend>
    <p>
        {if $pdf}
            {$data.biochemorg}
        {else}
            <textarea name="biochemorg" rows="5" cols="70" wrap="auto">{$data.biochemorg}</textarea>
        {/if}
    </p>
</fieldset>

<p />

{include file="coshh_common_bottom.tpl"}
