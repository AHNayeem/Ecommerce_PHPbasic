<?php
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';
// import the Intervention Image Manager Class
//use Intervention\Image\ImageManagerStatic as Image;
?>
<?php
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
}
if (isset($_POST['category'])) {
    $category_name = trim($_POST['category_name']);
    $category_photo = '';
    $errors = [];
    $msgs = [];
    //Validate
    if (strlen($category_name) < 3) {
        $errors[] = "Category name cannot be less than 3 characters.";
    }

    if (!empty($_FILES['category_photo']['tmp_name'])) {
        //File upload
        $category_photo = time() . $_FILES['category_photo']['name'];
        $destination = '../uploads/category/' . $category_photo;

//        //Code for Image Resize.     
//        $image = Image::make($_FILES['category_photo']['tmp_name'])
//                ->resize(250,250)
//                ->save();
//       
//        // create instance
//        $image->make($_FILES['category_photo']['tmp_name']);
//        // resize image to fixed size
//        $image->resize(250, 250);
//        //To auto save the image in location after resize
//        $image->save($destination);
//        
        
        move_uploaded_file($_FILES['category_photo']['tmp_name'], $destination);
    }

    if (empty($errors)) {
        //if succesful insert database.
        $query = $con->prepare("INSERT INTO categories(category_name,category_photo) VALUES(:category_name,:category_photo)");

        //SHOWING THE VALUES TO PLACEHLDERS IN QUERY.
        $query->bindValue('category_name', $category_name);
        $query->bindValue('category_photo', $category_photo);
        $query->execute();
        $msgs[] = 'Category added successfully.';
    }
}
?>

<?php
require_once 'adminheader.php';
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php require_once 'admin_sidebar.php'; ?>

        <div class=" col-sm-8">
            <h2>Add Category</h2>

            <?php if (!empty($errors)) { ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $v_error) { ?>
                        <p><?php echo $v_error; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (!empty($msgs)) { ?>
                <div class="alert alert-success">
                    <?php foreach ($msgs as $v_msg) { ?>
                        <p><?php echo $v_msg; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <form action="add_category.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label for="category_photo">Category Photo</label>
                    <input type="file" name="category_photo" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" name="category">Add Category</button>
                </div>
            </form>


        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php'; ?>