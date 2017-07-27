<?php session_start();?>
<?php
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
	header('Location: index.php');
}

?>

<?php
require_once 'adminheader.php';

?>
<!-- Page Content -->
<div class="container">
    <div class="row">
		<?php require_once 'admin_sidebar.php';?>
        <div class=" col-sm-8">
            <div class="alert alert-success">
                <p>You are logged in as <?php echo $_SESSION['username']; ?>.</p>

            </div>
        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php';?>