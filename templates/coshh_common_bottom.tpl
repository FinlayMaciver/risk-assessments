{* Smarty *}
<p class="break" />
<fieldset>
    <p>
        Should the work be carried out on the open bench, using other local exhaust ventilation, in a fume
        cupboard or in a glove box?<br />
        <textarea name="workspace" rows="5" cols="70" wrap="auto">{$data.workspace}</textarea>
    </p>
</fieldset>

<p />

<fieldset>
    <p>
        Personal protective equipment required for some or all aspects of the task :<br />
        {if $pdf}
            <ul>
            {foreach from=$data.equip item=e}
                <li>{$e}</li>
            {/foreach}
            </ul>
        {else}
            {html_checkboxes name="equip" values=$equip_opt output=$equip_opt selected=$data.equip separator='<br />'}
        {/if}
        <br />
        Other : <input type="text" name="equipother" value="{$data.equipother}" size="60" />
    </p>
</fieldset>

<p />

<fieldset>
    <legend>Supervision required</legend>
    <p>
        {if $pdf}
            <ul>
            {foreach from=$data.supervision item=e}
                <li>{$e}</li>
            {/foreach}
            </ul>
        {else}
            {html_checkboxes name="supervision" values=$supervision_val output=$supervision_out selected=$data.supervision separator='<br />'}
        {/if}
    </p>
</fieldset>

<p />

<fieldset>
    <legend>Monitoring</legend>
    <p>
        {if $pdf}
        <ul>
            {foreach from=$data.monitoring item=e}
            <li>{$e}</li>
            {/foreach}
        </ul>
        {else}
            {html_checkboxes name="monitoring" values=$monitor_val output=$monitor_out selected=$data.monitoring separator='<br />'}
        {/if}
    </p>
</fieldset>

<p />

<fieldset>
    <legend>Contingency Planning</legend>
    <p>
        {if $pdf}
           {if $data.writteninstructions eq "yes"}
                [Yes] : Written emergency instructions will be provided for workers and others on the site who might be affected
           {/if}
        {else}
            {html_checkboxes name="writteninstructions" values=$written_val output=$written_out selected=$data.writteninstructions}
        {/if}
    </p>
</fieldset>

<p class="break" />

<fieldset>
    <legend>The following may be required in an emergency</legend>
    <p>
        {if $pdf}
            <ul>
            {foreach from=$data.emergencyitems item=e}
                <li>{$e}</li>
            {/foreach}
            </ul>
        {else}
            {html_checkboxes name="emergencyitems" values=$emergency_val output=$emergency_out selected=$data.emergencyitems separator='<br />'}
        {/if}
        <br />
        Other : <input type="text" name="otheremergencyitems" value="{$data.otheremergencyitems}" size="60" />
    </p>
</fieldset>

<p />

<fieldset>
    <p>Disposal methods for materials used and wastes produced (if any) :</p>
    <p>
        {if $pdf}
            {$data.disposalmethod}
        {else}
            <textarea name="disposalmethod" rows="5" cols="70" wrap="auto">{$data.disposalmethod}</textarea>
        {/if}
    </p>
</fieldset>

<p />

<fieldset>
    <legend>Other persons who need to be told in full or in part about the information in this
    risk assessment</legend>
    {if $pdf}
        <ul>
        {foreach from=$data.peopleinform item=e}
            <li>{$e}</li>
        {/foreach}
        </ul>
    {else}
        {html_checkboxes name="peopleinform" values=$inform_val output=$inform_out selected=$data.peopleinform separator='<br />'}
    {/if}
</fieldset>

<p />

<fieldset>
    <legend>Any further information not already covered</legend>
    <p><em>(e.g, additional risks, additional hazardous substances and, when significant risks/hazards are present, a detailed scheme of work (if not given above))</em></p>
    <p>
        {if $pdf}
            {$data.otherinfo}
        {else}
            <textarea name="otherinfo" rows="5" cols="70" wrap="auto">{$data.otherinfo}</textarea>
        {/if}
    </p>
</fieldset>

<p />

<fieldset>
    {if $pdf}
        You are : {$data.persontype}
    {else}
        You are : <span style="background: #FFDDDD;">{html_radios name="persontype" values=$persontype_val output=$persontype_out selected=$data.persontype class="required"}</span>
    {/if}
    <br />
    <label for="persontype" class="error">You must indicate if you are staff or a student</label>
</fieldset>

<p />

<fieldset>
    <legend>Attach{if $forapproval}ed{/if} documents (e.g. MSDS's)</legend>
    {* if $forapproval || $foredit *}
        <ul>
        {foreach from=$files item=file}
            <li><a href="sendfile.php?id={$file.id}">{$file.filename}</a></li>
        {/foreach}
        </ul>
    {* /if *}
    {if ! $forapproval}
        <input type="file" name="Filedata1" /><br />
        <input type="file" name="Filedata2" /><br />
        <input type="file" name="Filedata3" /><br />
        <input type="file" name="Filedata4" /><br />
        <input type="file" name="Filedata5" /><br />
        <p class="fakehref" id="morefilelink">Click here to add more files</p>
        <p style="display:none" id="morefiles">
            <input type="file" name="Filedata6" /><br />
            <input type="file" name="Filedata7" /><br />
            <input type="file" name="Filedata8" /><br />
            <input type="file" name="Filedata9" /><br />
            <input type="file" name="Filedata10" /><br />
        </p>
    {/if}
</fieldset>

<p />

<fieldset>
    <p>
        Risk assessment prepared by (your email address) :<br />
        {if $pdf}
            {$data.personemail}
        {else}
            <input type="text" name="personemail" value="{$data.personemail}" size="60" class="required email"/>
        {/if}
    </p>
    <p>
        Supervisors email address :<br />
        {if $pdf}
            {$data.supervisor}
        {else}
            <input type="text" name="supervisor" value="{$data.supervisor}" size="60" />
        {/if}
    </p>
    <p>
        Lab responsible/guardian email address :<br />
        {if $pdf}
            {$data.labguardian}
        {else}
            <input type="text" name="labguardian" value="{$data.labguardian}" size="60" />
        {/if}
    </p>
</fieldset>

<p />

<fieldset>
{if $forapproval}
    <legend>Approval or rejection</legend>
    {if $pdf}
        <p>Document status : {$formdata.Status}</p>
    {else}
        <input name="action" type="radio" value="approve" checked="checked" /> Approve<br />
        <input name="action" type="radio" value="reject" /> Reject<br />
        &nbsp;<br />
        If rejecting - please give a reason :<br />
        <textarea name="ap_reason" rows="5" cols="70" wrap="auto"></textarea><br />
        <input type="hidden" name="approvemode" value="{$mode}" />
        {if $mode eq "coshhadmin"}
            <p>Supervisor status : {$formdata.StatusSupervisor}<br />
               Guardian status : {$formdata.StatusGuardian}
            </p>
        {/if}
    {/if}
{/if}

{if $mode ne "guest"}
    <input type="submit" name="submitcoshh" value="Submit" />
{else}
    <p><a href="view.php">Back to the form list</a></p>
{/if}
{if $mode eq "coshhadmin"}
    <p><a href="index.php?id={$formdata.uuid}&amp;godmode=1">Re-edit form</a></p>
{/if}
</fieldset>
</form>

