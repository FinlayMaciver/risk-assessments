{* Smarty *}
{if $forapproval}
<form method="POST" action="approve.php" id="coshhform" enctype="multipart/form-data">
<input type="hidden" name="uuid" value="{$formdata.uuid}" />
{else}
<form method="POST" action="index.php" id="coshhform" enctype="multipart/form-data">
<input type="hidden" name="action" value="submit_coshh" />
    {if $foredit}
    <input type="hidden" name="uuid" value="{$formdata.uuid}" />
    {if $godmode}
    <input type="hidden" name="godmode" value="yes" />
    {/if}
    {/if}
{/if}
<p />
<fieldset>
<legend>Overview</legend>
<p>
    Title of Task or Activity :<br />
    {if $pdf}
        {$data.title}
    {else}
        <input type="text" name="title" size="40" class="required" value="{$data.title}" />
    {/if}
</p>
<p>
    Location(s) where work will be carried out :<br />
    {if $pdf}
        {$data.location}
    {else}
        <input type="text" name="location" size="40" class="required" value="{$data.location}" />
    {/if}
</p>
<p>
    Short description of procedures involved in the activity :<br />
    {if $pdf}
        {$data.shortdesc}
    {else}
        <textarea name="shortdesc" rows="5" cols="70" wrap="auto" class="required">{$data.shortdesc}</textarea>
    {/if}
</p>
</fieldset>

<p class="break" />

<fieldset>
    <legend>Potential risks involved in preparing for or carrying out work</legend>

    {if !$pdf}
    <table border="1">
    <tr>
        <th>Risk</th>
        <th>Likelyhood <em>without</em> control measures</th>
        <th>Severity</th>
        <th>Control measures to mitigate risk, consequences of an incident, and how to deal
            with it where necessary</th>
        <th>Likelyhood <em>with</em> control measures</th>
    </tr>
    {/if}

    {section name=foof loop=4}
    {assign var=counter value=$smarty.section.foof.iteration}
    {assign var=risk value=$data.risk.$counter}

    {if !$pdf}
    <tr>
        <td valign="top"> 
            <textarea name="risk[{$counter}][riskname]" rows="3" cols="30" wrap="auto">{$risk.riskname}</textarea>
        </td>
        <td valign="top">
            {html_options name="risk[$counter][likely_wo]" values=$risk_likely_opt output=$risk_likely_opt selected=$risk.likely_wo}
        </td>
        <td valign="top">
            {html_options name="risk[$counter][severity]" values=$risk_severity_opt output=$risk_severity_opt selected=$risk.severity}
        </td>
        <td valign="top">
            <textarea name="risk[{$counter}][measures]" rows="3" cols="30" wrap="auto">{$risk.measures}</textarea>
        </td>
        <td valign="top">
            {html_options name="risk[$counter][likely_wi]" values=$risk_likely_opt output=$risk_likely_opt selected=$risk.likely_wi}
        </td>
    </tr>
    {else}
        {if $risk.riskname != ""}
        <p><em>Risk :</em><br />{$risk.riskname}</p>
        <p>
            <em>Likelyhood without control measures : </em> {$risk.likely_wo}<br />
            <em>Severity without control measures :</em> {$risk.severity}<br />
        </p>
        <p><em>Control measures :</em><br />{$risk.measures}</p>
        <p>
            <em>Likelyhood with control measures : </em> {$risk.likely_wi}<br />
        </p>
        <hr />
        {/if}
    {/if}
        
    {/section}

{if !$pdf}
</table>
{/if}
<p><em>Use the free text 'other' box at the end of the form to include more risks &amp; information if necessary</em></p>
</fieldset>
<p class="break" />

<fieldset>
<p>
    Specific control measures required for this task and not covered in the laboratory's General Code of 
    Practice :<br />
    <textarea name="specificmeasures" rows="5" cols="70" wrap="auto">{$data.specificmeasures}</textarea>
</p>
</fieldset>

