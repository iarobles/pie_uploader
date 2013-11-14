<script type="text/javascript">


    $(document).ready(function(){
       
        $("#pie-session-timeout-dialog").dialog({
            close:function(event,ui){
                location.href="index.php";
            }
        });

    });
    
</script>

<div id="pie-session-timeout-dialog" title="Your session has expired">
    <div>Your session has expired, please login again.</div>
</div>
