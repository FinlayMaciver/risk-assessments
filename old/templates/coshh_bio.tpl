{* Smarty *}

{include file="coshh_common_top.tpl"}
<input type="hidden" name="formtype" value="biological" />
<p class="break"/>

<fieldset>
    <legend>Hazards of micro-organisms involved</legend>
    {if !$pdf}
    <table border="1">
    <tr>
        <th>Micro-organism</th>
        <th>Hazard Classification - Advisory Committee on Dangerous Pathogens 1-4</th>
        <th>Risk to user or others</th>
        <th>Route by which micro-organism is hazardous to health</th>
        <th>Effect of single acute exposure</th>
        <th>Effect of repeated low exposure</th>
    </tr>
    {/if}
    {section name=foo loop=5}
    {assign var=counter value=$smarty.section.foo.iteration}
    {assign var=bio value=$data.bio.$counter}
    {if !$pdf}
    <tr>
        <td valign="top">
            <textarea name="bio[{$counter}][name]" rows="2" cols="20">{$bio.name}</textarea>
        </td>
        <td valign="top">
            {html_options name="bio[$counter][category]" values=$bio_cat_opt output=$bio_cat_opt selected=$bio.category}
        </td>
        <td valign="top">
            {html_options name="bio[$counter][risk]" values=$bio_risk_opt output=$bio_risk_opt selected=$bio.risk}
        </td>
        <td valign="top">
            {html_options name="bio[$counter][route_a][]" values=$bio_route_a_opt output=$bio_route_a_opt selected=$bio.route_a multiple="1"}
            {html_options name="bio[$counter][route_b][]" values=$bio_route_b_opt output=$bio_route_b_opt selected=$bio.route_b multiple="1"}
        </td>
        <td valign="top">
            {html_options name="bio[$counter][singleexposure]" values=$haz_exposure_opt output=$haz_exposure_opt selected=$bio.singleexposure}
        </td>
        <td valign="top">
            {html_options name="bio[$counter][repeatexposure]" values=$haz_exposure_opt output=$haz_exposure_opt selected=$bio.repeatexposure}
        </td>
    </tr>
    {else}
        {if $bio.name != ""}
        <p><em>Micro-organism</em> :<br />{$bio.name}</p>
        <p>
            <em>Classification</em> : {$bio.category}<br />
            <em>Risk</em> : {$bio.risk}<br />
            <em>Route</em> : {foreach from=$bio.route_a item=e}{$e}, {/foreach} / {foreach from=$bio.route_b item=e}{$e}, {/foreach}<br />
            <em>Single exposure</em> : {$bio.singleexposure}<br />
            <em>Repeated exposure</em> : {$bio.repeatexposure}
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

<p />

<fieldset>
    <legend>Hazardous chemicals and biochemicals involved</legend>
    <p><em>(Upload appropriate MSDS's at the end of this form)</em></p>
    {if !$pdf}
    <table border="1">
    <tr>
        <th>Substance</th>
        <th>Hazard Classification</th>
        <th>Quantity</th>
        <th>Route by which substance is hazardous to health</th>
        <th>Effect of single acute exposure</th>
        <th>Effect of repeated low exposure</th>
    </tr>
    {/if}
    {section name=foo loop=5}
    {assign var=counter value=$smarty.section.foo.iteration}
    {assign var=haz value=$data.haz.$counter}
    {if !$pdf}
    <tr>
        <td valign="top">
            <textarea name="haz[{$counter}][name]" rows="2" cols="20">{$haz.name}</textarea>
        </td>
        <td valign="top">
            {html_options name="haz[$counter][level][]" values=$haz_level_opt output=$haz_level_opt selected=$haz.level multiple="1"}
            {html_options name="haz[$counter][type][]" values=$haz_type_opt output=$haz_type_opt selected=$haz.type multiple="1"}
        </td>
        <td valign="top">
            {html_options name="haz[$counter][quantity]" values=$haz_quant_val output=$haz_quant_out selected=$haz.quantity}
        </td>
        <td valign="top">
            {html_options name="haz[$counter][route][]" values=$haz_route_opt output=$haz_route_opt selected=$haz.route multiple="1"}
        </td>
        <td valign="top">
            {html_options name="haz[$counter][singleexposure]" values=$haz_exposure_opt output=$haz_exposure_opt selected=$haz.singleexposure}
        </td>
        <td valign="top">
            {html_options name="haz[$counter][repeatexposure]" values=$haz_exposure_opt output=$haz_exposure_opt selected=$haz.repeatexposure}
        </td>
    </tr>
    {else}
        {if $haz.name != ""}
        <p><em>Hazard</em> :<br />{$haz.name}</p>
        <p>
            <em>Level</em> : {foreach from=$haz.level item=e}{$e}, {/foreach}<br />
            <em>Type</em> : {foreach from=$haz.type item=e}{$e}, {/foreach}<br />
            <em>Quantity</em> : {$haz.quantity}<br />
            <em>Route</em> : {foreach from=$haz.route item=e}{$e}, {/foreach}<br />
            <em>Single exposure</em> : {$haz.singleexposure}<br />
            <em>Repeated exposure</em> : {$haz.repeatexposure}
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

{include file="coshh_common_bottom.tpl"}
