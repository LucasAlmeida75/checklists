
<?php if (!isset($data['sidebarOff'])) {
    $this->view("structure/sidebarfooter");
} ?>
<script src="<?php echo $this->siteUrl("js/bootstrap.js"); ?>"></script>
<script src="<?php echo $this->siteUrl("js/functions.js"); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<?php
    $controllerName = $_SESSION["currentController"];
    if (file_exists("../public/js/$controllerName.js")) {
?>
<script src="<?php echo $this->siteUrl("js/$controllerName.js"); ?>"></script>
<?php } ?>
</body>
</html>