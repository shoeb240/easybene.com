<?
$upgrade = 0; 
if(isset($_GET['upgrade'])) {
    $upgrade = 1;
}
?>
<script>
var upgrade =  <?=$upgrade?>;
if(upgrade == '0') {
    document.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']?>/index/premium-successful';
} else {
    document.location.href = 'http://<?php echo $_SERVER['HTTP_HOST']?>/index/after_upgrade_membership';
}
</script>
