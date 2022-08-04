<?php

function show(...$expressions)
{
    foreach ($expressions as $expression) {
        echo "<pre>";
        print_r($expression);
        echo "</pre>";
    }
}

function dump(...$expressions)
{
    foreach ($expressions as $expression) {
        echo "<pre>";
        var_dump($expression);
        echo "</pre>";
    }
}
