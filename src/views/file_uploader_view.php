
<script type="text/javascript">
    $(document).ready(function(){
        var filesNotUploaded = <?php echo sizeof($filesNotUploaded); ?>;
        if(filesNotUploaded>0){
            <?php for ($i = 0; $i < $totalNotUploaded; $i++): ?>
                $("#upload_error_message<?php echo $i; ?>").html("<?php echo $filesNotUploaded[$i]; ?>");
                $("#upload_error_message<?php echo $i; ?>").addClass("ui-state-error");
            <?php endfor; ?>
        }

        $("#upload-result-dialog").dialog({
          close:function(event,ui){
              var completeFilePath = "<?php echo $exploredPath;?>";
              //alert("completeFilePath:" + completeFilePath);
              reloadFileExplorer(completeFilePath);
          }
        });

        //finally we reload the explorer panel
    });

</script>

<div id="upload-result-dialog" title="Results of your uploading">
    
    <p>
             <div>Files uploaded:<?php echo $totalUploaded; ?></div>
        <div>Files not uploaded:<?php echo sizeof($filesNotUploaded); ?></div>
        <?php for ($i = 0; $i < $totalNotUploaded; $i++): ?>
            <div id="upload_error_message<?php echo $i; ?>"></div>
        <?php endfor; ?>
        <div>Uploaded files:
            <?php foreach($filesUploaded as $fileUploaded): ?>
                <?php echo $fileUploaded;?>,
            <?php endforeach;?>
        </div>
    </p>
</div>