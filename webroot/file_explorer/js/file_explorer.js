var fileExplorerCounter = 0;

$(document).ready(function(){

    $("#file_upload").button();
    $("#file_upload").click(function(event){

        $('#file-explorer-upload-form').ajaxForm({
            target:"#file-explorer-upload-results",
            success: function(){
                $("#file-explorer-upload-results").fadeIn("slow");
            }
        });
    });
    
    $("#accordion").accordion({
        header:"h3",
        autoHeight:false
    });

    var fileExplorerGridTitle = "Exploring:  " + $("#file-explorer-current-path").attr("value");
    $("#file-explorer").flexigrid({
        title:fileExplorerGridTitle,
        height:'auto',
        showTableToggleBtn: true
    });

    $(".tooltipable").tipTip();

    
});

function insertInputFile(divNumberAfterInsert){
    fileExplorerCounter = fileExplorerCounter +1;
    var htmlToInsert ="<div id='file-input-box" + fileExplorerCounter+"'><input name='uploads[]' type='file' class='multi'/>";
    htmlToInsert += "<a href='javascript:insertInputFile(" + fileExplorerCounter +");' class='tooltipable' title='add file input'>";
    htmlToInsert += "<img src='./webroot/img/icons/add.png' alt='add'/></a></div>";    
    var insertAfterDiv = "#file-input-box" + divNumberAfterInsert;
    //alert(htmlToInsert + " div:" + insertAfterDiv);
    $(htmlToInsert).insertAfter(insertAfterDiv);
}

function reloadFileExplorer(completeFilePath){
    var isZip = $("#fileAdminIsZipInput").attr("value");
    var urlToLoad = "./src/controllers/file_explorer_controller.php?dir="+encodeURIComponent(completeFilePath) + "&isZip=" + isZip;
    //alert("urlToLoad:" + urlToLoad);
    $("#file-admin-explorer").load(urlToLoad);
}

function deleteFileOrDirectory(currentExploringPath,fileToDeletePath){

    var urlToRequest = "./src/controllers/file_explorer_controller.php?action=delete&fileToDeletePath="+encodeURIComponent(fileToDeletePath)+'&dir=' + encodeURIComponent(currentExploringPath);
    //alert("urlToRequest" + urlToRequest);
    $("#file-admin-explorer-results").load(urlToRequest);
    
}

