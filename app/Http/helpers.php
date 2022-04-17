<?php

function getStatus($status){
    if($status == 'done' || $status == '1' || $status == '100') return 'paid';
    if($status == 'wait' || $status == '2' || $status == '200') return 'pending';
    if($status == 'nope' || $status == '3' || $status == '300') return 'reject';
}