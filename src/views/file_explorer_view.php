<?php
include_once "view_utils.php";
?>

<script type="text/javascript" src="./webroot/file_explorer/js/file_explorer.js"></script>
<div class="pie-90pc-box-nobg pie-box-center pie-box-vpadding-10-nobg"></div>

<div id="accordion" class="pie-90pc-box-nobg pie-box-center">
    <div>
        <?php if ($isZipForm == "false"): ?>
            <h3><a href="#">Manage Files</a></h3>
        <?php else: ?>
                <h3><a href="#">Manage ZIPS</a></h3>
        <?php endif; ?>
                <div>
                    <input id="file-explorer-current-path" type="hidden" value="<?php echo $currentExploringPath; ?>"/>
                    <div class="file-explorer-container-box pie-box-center">
                        <table id="file-explorer">
                            <thead>
                                <tr>
                                    <th width="450">File name</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php foreach ($filesFound as $fileFound): ?>
                            <tr>
                                <td>
                                <?php if ($fileFound->getIsDir() == true): ?>
                                    <a href="javascript:reloadFileExplorer('<?php echo $fileFound->getHtdocsPath(); ?>')">
                                        <img alt="" src="./webroot/img/icons/extensions/<?php echo $fileFound->getImageFileExtension(); ?>" />
                                    </a>
                                <?php else: ?>
                                        <img alt="" src="./webroot/img/icons/extensions/<?php echo $fileFound->getImageFileExtension(); ?>" />
                                <?php endif; ?>
                                <?php echo $fileFound->getFileName(); ?>
                                    </td>
                                    <td>
                                <?php if ($fileFound->getFileName() != "." && $fileFound->getFileName() != ".."): ?>
                                            <a href="javascript:deleteFileOrDirectory('<?php echo dirname($fileFound->getHtdocsPath()); ?>', '<?php echo $fileFound->getCompletePath(); ?>');" class="tooltipable" title="delete">
                                                <img src="./webroot/img/icons/delete.png" alt="delete"/>
                                            </a>
                                            <!-- <a href="" class="tooltipable" title="rename"><img src="./webroot/img/icons/report_edit.png" alt="edit"/></a> -->
                                <?php endif; ?>
                                        </td>
                                    </tr>
                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <div class="pie-box-vpadding-30-nobg"></div>
                                    <div class="file-explorer-input-box">
                                        <form id="file-explorer-upload-form" enctype="multipart/form-data" method="post" action="./src/controllers/file_uploader_controller.php?isZip=<?php echo $isZipForm; ?>" >
                                            <input type="hidden" name="exploredPath" value="<?php echo $currentExploringPath; ?>" />
                                            <div id="file-input-box0"><input type="file" class="multi" name="uploads[]"/>
                            <?php if ($isZipForm == "false"): ?>
                                                <a href="javascript:insertInputFile(0);" class="tooltipable" title="add file input">
                                                    <img src="./webroot/img/icons/add.png" alt="add"/>
                                                </a>
                            <?php endif; ?>
                        </div>
                        <div style="padding-top:5px"><input id="file_upload" class="button_text" type="submit" value="upload!"/></div>
                        <div id="file-explorer-upload-results"></div>
                        <div id="file-admin-explorer-results"></div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
