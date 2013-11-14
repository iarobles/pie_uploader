<?php

//this file assumes that always the controller pass to him a variable named $viewParams
//TODO:find a better way to create dynamic variables(this variables are passed from controller)
//because use eval is totally insane
foreach ($viewParams->getParams() as $paramName => $paramValue) {
    $fakeVariable = "\$" . $paramName . "=\$viewParams->get(\"" . $paramName . "\");";
    //echo "fakeVariable: ".$fakeVariable."<br/>";
    eval($fakeVariable);
}
?>
