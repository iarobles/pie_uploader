<?php
include_once "view_utils.php";
?>

<style type="text/css">
    /* TODO shouldn't be necessary */
    .ui-button { margin-left: -1px; }
    .ui-button-icon-only .ui-button-text { padding: 0.35em; }
    .ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
</style>

<script type="text/javascript">

    $(function() {
        $("#combobox").combobox();
    });

    //just for testing
    //$("#file-admin-explorer").load("./src/controllers/file_explorer_controller.php?dir=/test");
</script>


<div class="pie-box-vpadding-20-nobg"></div>
<div class="demo">

    <div class="ui-widget">
        <label>Path</label>
        <select id="combobox">
            <?php foreach ($allowedPaths as $allowedPath): ?>
                <option id="<?php echo $allowedPath->getPath(); ?>"><?php echo $allowedPath->getPath(); ?></option>
            <?php endforeach; ?>
                <option></option>
            </select>
        </div>    

    </div>
    <div id="file-admin-explorer"></div>

    <input id="fileAdminIsZipInput" type="hidden" value="<?php echo $isZip; ?>"/>