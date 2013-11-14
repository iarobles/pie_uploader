<?php
include_once "view_utils.php";
?>

<script type="text/javascript" >
    $("#delete-file-result-dialog").dialog({
        close:function(event,ui){
            var completeFilePath = "<?php echo $currentExploringPath; ?>";
            //alert("completeFilePath:" + completeFilePath);
            reloadFileExplorer(completeFilePath);
        }
    });
</script>

<div id="delete-file-result-dialog" title="Results of your request">
    <div>Deleted Files:<?php echo basename($fileToDeletePath); ?></div>
</div>