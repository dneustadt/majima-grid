<div class="{$col.classes}">
    {block "grid-col"}
        <div class="col-panel--inner"{if $.admin} data-column-edit="true" data-widget-type="{$col.type}"{/if}>
            {block "grid-col-subject"}
                {$col.subject}
            {/block}
        </div>
        {if $.admin}<a class="del-column button button-small" data-del-column="true"><span class="typcn typcn-minus"></span></a>{/if}
    {/block}
</div>