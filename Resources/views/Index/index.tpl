{inherits "Index/index.tpl"}

{block "content"}
    {$dwoo.parent}
    <div class="section">
        {block "pre-grid"}
            {if $.admin && !empty($revisions)}
                <div class="container">
                    <div class="row">
                        <div class="col-xs-offset-8 col-xs-2 col-md-offset-10 col-md-1">
                            <label for="revisions">Revision</label>
                        </div>
                        <div class="col-xs-2 col-md-1">
                            <select data-revision-select="true" id="revisions">
                                {foreach $revisions revision}
                                    <option value="{$revision}"{if $revision == $current_revision} selected{/if}>
                                        {$revision}
                                    </option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
            {/if}
        {/block}

        {block "grid-outer"}
            <div class="container grid{if $.admin} is--editable{/if}"{if $.admin} data-upload-url="{url "admin_image_upload"}"{/if}>
                {block "grid"}
                    {foreach $rows row}
                        {include "Index/partials/row.tpl"}
                    {foreachelse}
                        {include "Index/partials/row.tpl"}
                    {/foreach}
                {/block}
            </div>
        {/block}

        {block "post-grid"}
            {if $.admin}<a class="button save-grid" data-save-grid="true" data-url="{url "admin_save_grid" array('p' => $pageId)}"><span class="typcn typcn-tick"></span> Save grid</a>{/if}
        {/block}
    </div>
{/block}