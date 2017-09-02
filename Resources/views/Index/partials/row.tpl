{block "grid-row-outer"}
    <div class="row">
        {block "grid-row"}
            {foreach $row col}
                {include "Index/partials/col.tpl"}
            {/foreach}
            {if $.admin}<a class="add-column button button-small" data-add-column="true"><span class="typcn typcn-plus"></span> Column</a>{/if}
        {/block}
    </div>
    {if $.admin}<a class="add-row button button-small" data-add-row="true"><span class="typcn typcn-plus"></span> Row</a>{/if}
{/block}